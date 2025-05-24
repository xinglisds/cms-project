<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">
                    Admin Access
                </span>
                <a href="{{ route('admin.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Back to Admin Panel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Articles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Articles</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Article::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Comments</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Comment::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Subscribers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Newsletter Subscribers</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Subscriber::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                    
                    <div class="space-y-4">
                        <!-- Recent Articles -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Latest Articles</h4>
                            <div class="space-y-2">
                                @forelse(\App\Models\Article::latest()->take(3)->get() as $article)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $article->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('articles.show', $article->slug) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            View
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No articles yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Comments -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Latest Comments</h4>
                            <div class="space-y-2">
                                @forelse(\App\Models\Comment::with(['user', 'article'])->latest()->take(3)->get() as $comment)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                            <p class="text-xs text-gray-600">on "{{ Str::limit($comment->article->title, 30) }}"</p>
                                            <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('articles.show', $comment->article->slug) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            View
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">No comments yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Information -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-blue-800 font-medium">Dashboard Information</h3>
                        <p class="text-blue-700 text-sm mt-1">
                            This dashboard provides a quick overview of your CMS statistics. 
                            All data is updated in real-time and reflects the current state of your system.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 