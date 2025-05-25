@section('title', config('app.name') . ' - Latest Articles, Insights & Stories')

@section('meta_description', 'Discover the latest articles, insights, and stories from our community of writers and contributors. Stay up to date with our newest content.')

@section('meta_keywords', 'articles, blog, insights, stories, latest news, community, writers')

@section('canonical', route('home'))

@section('og_type', 'website')
@section('og_title', config('app.name') . ' - Latest Articles, Insights & Stories')
@section('og_description', 'Discover the latest articles, insights, and stories from our community of writers and contributors.')
@section('og_url', route('home'))

@section('twitter_title', config('app.name') . ' - Latest Articles, Insights & Stories')
@section('twitter_description', 'Discover the latest articles, insights, and stories from our community of writers and contributors.')

<x-app-layout>
    <div class="bg-gradient-to-b from-blue-50 to-white">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block">Welcome to</span>
                        <span class="block text-blue-600">{{ config('app.name', 'CMS') }}</span>
                    </h1>
                    <p class="mt-6 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-8 md:text-xl md:max-w-3xl">
                        Discover the latest articles, insights, and stories from our community of writers and contributors.
                    </p>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-2 text-sm text-green-600">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="ml-2 text-sm text-red-600">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Articles Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            @if($articles->count() > 0)
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Latest Articles</h2>
                    <p class="mt-4 text-lg text-gray-600">Stay up to date with our newest content</p>
                </div>

                <!-- Featured Article (First Article) -->
                @if($articles->isNotEmpty())
                    <div class="mb-16">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                                <div class="aspect-w-16 aspect-h-9 lg:aspect-none">
                                    @if($articles->first()->cover_image)
                                        <img src="{{ Storage::url($articles->first()->cover_image) }}" 
                                             alt="{{ $articles->first()->title }}"
                                             class="w-full h-64 lg:h-full object-cover">
                                    @else
                                        <div class="w-full h-64 lg:h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-8 lg:p-12 flex flex-col justify-center">
                                    <div class="flex items-center text-sm text-blue-600 font-medium mb-4">
                                        <span class="bg-blue-100 px-3 py-1 rounded-full">Featured</span>
                                    </div>
                                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                                        <a href="{{ route('articles.show', $articles->first()->slug) }}" 
                                           class="hover:text-blue-600 transition-colors duration-200">
                                            {{ $articles->first()->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                                        {{ Str::limit(strip_tags($articles->first()->content), 200) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <time class="text-sm text-gray-500" datetime="{{ $articles->first()->created_at->toISOString() }}">
                                            {{ $articles->first()->created_at->format('F j, Y') }}
                                        </time>
                                        <a href="{{ route('articles.show', $articles->first()->slug) }}" 
                                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                            Read more
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- More Articles Grid -->
                @if($articles->count() > 1)
                    <div class="mb-12">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">More Articles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($articles->skip(1) as $article)
                                <x-article-card :article="$article" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $articles->links() }}
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-16">
                    <a href="{{ route('articles.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                        View All Articles
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Newsletter Subscription Card -->
                <div class="mt-16 mb-16">
                    <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        
                        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                            Stay Updated
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Subscribe to our newsletter and never miss our latest articles and insights.
                        </p>
                        
                        <form action="{{ route('subscribe') }}" method="POST" class="max-w-md mx-auto">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1">
                                    <label for="email" class="sr-only">Email address</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Enter your email address"
                                           value="{{ old('email') }}"
                                           required>
                                </div>
                                <div>
                                    <button type="submit" 
                                            class="w-full sm:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 flex items-center justify-center">
                                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Subscribe
                                    </button>
                                </div>
                            </div>
                            
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </form>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                We respect your privacy. Unsubscribe at any time.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="mt-6 text-xl font-medium text-gray-900">No articles yet</h3>
                    <p class="mt-2 text-gray-500">Get started by creating your first article.</p>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <div class="mt-6">
                                <a href="/admin/articles/create" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Create Article
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 