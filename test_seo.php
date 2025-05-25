<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test URLs
$urls = [
    '/',
    '/articles',
];

echo "Testing SEO Tags Implementation\n";
echo "================================\n\n";

foreach ($urls as $url) {
    echo "Testing URL: $url\n";
    echo str_repeat('-', 50) . "\n";
    
    $request = Request::create($url, 'GET');
    $response = $kernel->handle($request);
    
    $content = $response->getContent();
    
    // Check for title tag
    if (preg_match('/<title>(.*?)<\/title>/s', $content, $matches)) {
        echo "✓ Title: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ Title tag not found\n";
    }
    
    // Check for meta description
    if (preg_match('/<meta name="description" content="(.*?)"/s', $content, $matches)) {
        echo "✓ Meta Description: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ Meta description not found\n";
    }
    
    // Check for canonical URL
    if (preg_match('/<link rel="canonical" href="(.*?)"/s', $content, $matches)) {
        echo "✓ Canonical URL: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ Canonical URL not found\n";
    }
    
    // Check for Open Graph tags
    if (preg_match('/<meta property="og:title" content="(.*?)"/s', $content, $matches)) {
        echo "✓ OG Title: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ OG Title not found\n";
    }
    
    if (preg_match('/<meta property="og:description" content="(.*?)"/s', $content, $matches)) {
        echo "✓ OG Description: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ OG Description not found\n";
    }
    
    // Check for Twitter Card tags
    if (preg_match('/<meta name="twitter:title" content="(.*?)"/s', $content, $matches)) {
        echo "✓ Twitter Title: " . trim($matches[1]) . "\n";
    } else {
        echo "✗ Twitter Title not found\n";
    }
    
    echo "\n";
}

echo "SEO Tags Test Complete!\n"; 