<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Article Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('articles.index') }}" class="hover:text-gray-700">Articles</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-700">{{ $article->title }}</span>
                    </div>
                </nav>

                <!-- Article Title and Meta -->
                <header>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <time datetime="{{ $article->created_at->toISOString() }}">
                                {{ $article->created_at->format('F j, Y') }}
                            </time>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                {{ $article->comments->count() }} {{ Str::plural('comment', $article->comments->count()) }}
                            </span>
                            @if($article->is_imported)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    External Source
                                </span>
                            @endif
                        </div>
                        
                        @if($article->is_imported && $article->source_url)
                            <a href="{{ $article->source_url }}" 
                               target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                View Original
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </header>
            </div>
        </div>

        <!-- Article Content and Sidebar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header Ads - Between title and content -->
            <div class="mb-8">
                <div class="max-w-4xl mx-auto">
                    <x-ad-banner position="header" :limit="3" />
                </div>
            </div>

            <div class="lg:grid lg:grid-cols-1 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-1">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="ml-2 text-sm text-green-600">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="ml-2 text-sm text-red-600">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                        @if($article->cover_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ Storage::url($article->cover_image) }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-80 object-cover">
                            </div>
                        @endif
                        
                        <div class="p-8 lg:p-12">
                            <div class="prose prose-lg prose-blue max-w-none">
                                {!! nl2br(e($article->content)) !!}
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    <div class="mt-12 bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-8 lg:p-12">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                                Comments ({{ $article->comments->count() }})
                            </h2>
                            
                            <!-- Comment Form -->
                            @auth
                                <div class="mb-8 border-b border-gray-200 pb-8">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Leave a Comment</h3>
                                    <form action="{{ route('comments.store', $article) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                                Your Comment
                                            </label>
                                            <textarea name="content" 
                                                      id="content" 
                                                      rows="4" 
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                                      placeholder="Share your thoughts..."
                                                      required
                                                      minlength="3"
                                                      maxlength="1000">{{ old('content') }}</textarea>
                                            @error('content')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">
                                                Logged in as <strong>{{ Auth::user()->name }}</strong>
                                            </span>
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Post Comment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="mb-8 border-b border-gray-200 pb-8">
                                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <p class="text-gray-600 mb-4">Please log in to leave a comment</p>
                                        <div class="space-x-3">
                                            <a href="{{ route('login') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                                                Log In
                                            </a>
                                            <a href="{{ route('register') }}" 
                                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                Register
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                            
                            <!-- Comments List -->
                            @forelse($article->comments as $comment)
                                <div class="flex space-x-4 py-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Comment Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $comment->user->name }}
                                            </h4>
                                            <time class="text-sm text-gray-500" datetime="{{ $comment->created_at->toISOString() }}">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </time>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No comments yet</h3>
                                    <p class="mt-2 text-gray-500">Be the first to share your thoughts!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('articles.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Articles
                        </a>
                        
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                            Home
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Ads -->
            <div class="mt-12">
                <x-ad-banner position="footer" :limit="3" />
            </div>
        </div>
    </div>
</x-app-layout> 