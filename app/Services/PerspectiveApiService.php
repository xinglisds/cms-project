<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

class PerspectiveApiService
{
    private $client;
    private $apiKey;
    private $baseUrl = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze';
    
    // Toxicity threshold (0.0 to 1.0, where 1.0 is most toxic)
    private $toxicityThreshold = 0.7;
    
    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10, // 10 seconds timeout
            'connect_timeout' => 5, // 5 seconds connection timeout
        ]);
        
        $this->apiKey = config('services.perspective.api_key');
    }
    
    /**
     * Analyze comment text for toxicity and other harmful content
     *
     * @param string $text
     * @return array
     */
    public function analyzeComment(string $text): array
    {
        // If API key is not configured, allow the comment (fail open)
        if (empty($this->apiKey)) {
            Log::warning('Perspective API key not configured, allowing comment');
            return [
                'allowed' => true,
                'reason' => 'API not configured',
                'scores' => []
            ];
        }
        
        try {
            $response = $this->client->post($this->baseUrl, [
                'query' => ['key' => $this->apiKey],
                'json' => [
                    'requestedAttributes' => [
                        'TOXICITY' => (object)[],
                        'SEVERE_TOXICITY' => (object)[],
                        'IDENTITY_ATTACK' => (object)[],
                        'INSULT' => (object)[],
                        'PROFANITY' => (object)[],
                        'THREAT' => (object)[],
                    ],
                    'comment' => [
                        'text' => $text
                    ],
                    'languages' => ['en', 'zh'] // Support English and Chinese
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['attributeScores'])) {
                Log::error('Perspective API returned unexpected response format', ['response' => $data]);
                return [
                    'allowed' => true,
                    'reason' => 'API response format error',
                    'scores' => []
                ];
            }
            
            $scores = $this->extractScores($data['attributeScores']);
            $isAllowed = $this->isCommentAllowed($scores);
            
            // Log the analysis for monitoring
            Log::info('Perspective API analysis completed', [
                'text_length' => strlen($text),
                'scores' => $scores,
                'allowed' => $isAllowed
            ]);
            
            return [
                'allowed' => $isAllowed,
                'reason' => $isAllowed ? 'Content approved' : 'Content flagged as inappropriate',
                'scores' => $scores
            ];
            
        } catch (ConnectException $e) {
            Log::error('Perspective API connection timeout', [
                'error' => $e->getMessage(),
                'text_length' => strlen($text)
            ]);
            
            return [
                'allowed' => true,
                'reason' => 'API connection timeout - allowing comment',
                'scores' => []
            ];
            
        } catch (RequestException $e) {
            Log::error('Perspective API request failed', [
                'error' => $e->getMessage(),
                'status_code' => $e->getResponse() ? $e->getResponse()->getStatusCode() : null,
                'text_length' => strlen($text)
            ]);
            
            return [
                'allowed' => true,
                'reason' => 'API request failed - allowing comment',
                'scores' => []
            ];
            
        } catch (\Exception $e) {
            Log::error('Perspective API unexpected error', [
                'error' => $e->getMessage(),
                'text_length' => strlen($text)
            ]);
            
            return [
                'allowed' => true,
                'reason' => 'Unexpected error - allowing comment',
                'scores' => []
            ];
        }
    }
    
    /**
     * Extract scores from API response
     *
     * @param array $attributeScores
     * @return array
     */
    private function extractScores(array $attributeScores): array
    {
        $scores = [];
        
        foreach ($attributeScores as $attribute => $data) {
            if (isset($data['summaryScore']['value'])) {
                $scores[strtolower($attribute)] = round($data['summaryScore']['value'], 3);
            }
        }
        
        return $scores;
    }
    
    /**
     * Determine if comment should be allowed based on scores
     *
     * @param array $scores
     * @return bool
     */
    private function isCommentAllowed(array $scores): bool
    {
        // Check each score against thresholds
        $thresholds = [
            'toxicity' => 0.7,
            'severe_toxicity' => 0.5,
            'identity_attack' => 0.7,
            'insult' => 0.7,
            'profanity' => 0.8,
            'threat' => 0.5,
        ];
        
        foreach ($thresholds as $attribute => $threshold) {
            if (isset($scores[$attribute]) && $scores[$attribute] >= $threshold) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get a user-friendly message for rejected comments
     *
     * @param array $scores
     * @return string
     */
    public function getRejectionMessage(array $scores): string
    {
        $highScores = [];
        
        $thresholds = [
            'toxicity' => 0.7,
            'severe_toxicity' => 0.5,
            'identity_attack' => 0.7,
            'insult' => 0.7,
            'profanity' => 0.8,
            'threat' => 0.5,
        ];
        
        foreach ($thresholds as $attribute => $threshold) {
            if (isset($scores[$attribute]) && $scores[$attribute] >= $threshold) {
                $highScores[] = $attribute;
            }
        }
        
        if (in_array('threat', $highScores) || in_array('severe_toxicity', $highScores)) {
            return 'Your comment contains threatening or severely inappropriate language. Please revise your comment to be more respectful.';
        }
        
        if (in_array('insult', $highScores) || in_array('identity_attack', $highScores)) {
            return 'Your comment may contain insulting or offensive language. Please modify your comment to be more constructive.';
        }
        
        if (in_array('profanity', $highScores)) {
            return 'Your comment contains inappropriate language. Please remove any offensive words and try again.';
        }
        
        return 'Your comment content may be inappropriate. Please modify your comment and try again.';
    }
} 