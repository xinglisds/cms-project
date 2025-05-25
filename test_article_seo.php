<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Article;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Get first article
$article = Article::first();

if (!$article) {
    echo "No articles found in database.\n";
    exit(1);
}

$url = "/articles/{$article->slug}";

echo "Testing Article SEO Tags\n";
echo "========================\n";
echo "Article: {$article->title}\n";
echo "URL: $url\n\n";

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

if (preg_match('/<meta property="og:type" content="(.*?)"/s', $content, $matches)) {
    echo "✓ OG Type: " . trim($matches[1]) . "\n";
} else {
    echo "✗ OG Type not found\n";
}

// Check for article specific meta tags
if (preg_match('/<meta property="article:published_time" content="(.*?)"/s', $content, $matches)) {
    echo "✓ Article Published Time: " . trim($matches[1]) . "\n";
} else {
    echo "✗ Article Published Time not found\n";
}

if (preg_match('/<meta property="article:modified_time" content="(.*?)"/s', $content, $matches)) {
    echo "✓ Article Modified Time: " . trim($matches[1]) . "\n";
} else {
    echo "✗ Article Modified Time not found\n";
}

// Check for Twitter Card tags
if (preg_match('/<meta name="twitter:title" content="(.*?)"/s', $content, $matches)) {
    echo "✓ Twitter Title: " . trim($matches[1]) . "\n";
} else {
    echo "✗ Twitter Title not found\n";
}

if (preg_match('/<meta name="twitter:card" content="(.*?)"/s', $content, $matches)) {
    echo "✓ Twitter Card: " . trim($matches[1]) . "\n";
} else {
    echo "✗ Twitter Card not found\n";
}

echo "\nArticle SEO Tags Test Complete!\n"; 