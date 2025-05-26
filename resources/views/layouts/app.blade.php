<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Dynamic Title -->
        <title>@yield('title', config('app.name', 'LiteCMS'))</title>

        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('meta_description', 'A modern content management system built with LiteCMS')">
        <meta name="keywords" content="@yield('meta_keywords', 'CMS, LiteCMS, Content Management')">
        <meta name="author" content="@yield('author', config('app.name'))">
        
        @hasSection('meta_description')
            <meta name="description" content="@yield('meta_description')">
        @endif
        
        @hasSection('meta_keywords')
            <meta name="keywords" content="@yield('meta_keywords')">
        @endif

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="@yield('og_title', config('app.name', 'LiteCMS'))">
        <meta property="og:description" content="@yield('og_description', 'A modern content management system')">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:url" content="@yield('og_url', request()->url())">
        <meta property="og:image" content="@yield('og_image', asset('images/default-og-image.jpg'))">
        <meta property="og:site_name" content="{{ config('app.name', 'LiteCMS') }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        @hasSection('twitter_title')
            <meta name="twitter:title" content="@yield('twitter_title')">
        @endif
        
        @hasSection('twitter_description')
            <meta name="twitter:description" content="@yield('twitter_description')">
        @endif
        
        @hasSection('twitter_image')
            <meta name="twitter:image" content="@yield('twitter_image')">
        @endif

        <!-- Canonical URL -->
        @hasSection('canonical')
            <link rel="canonical" href="@yield('canonical')">
        @endif

        <!-- Article specific meta tags -->
        @hasSection('article_published_time')
            <meta property="article:published_time" content="@yield('article_published_time')">
        @endif
        
        @hasSection('article_modified_time')
            <meta property="article:modified_time" content="@yield('article_modified_time')">
        @endif
        
        @hasSection('article_author')
            <meta property="article:author" content="@yield('article_author')">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Head Content -->
        @stack('head')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>
