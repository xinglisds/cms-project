<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <article class="p-6">
                    @if($article->cover_image)
                        <img src="{{ Storage::url($article->cover_image) }}" 
                             alt="{{ $article->title }}"
                             class="w-full h-64 object-cover rounded mb-6">
                    @endif
                    
                    <header class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
                        
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span>Published {{ $article->created_at->format('F d, Y') }}</span>
                            @if($article->is_imported && $article->source_url)
                                <span>•</span>
                                <a href="{{ $article->source_url }}" 
                                   target="_blank" 
                                   class="text-blue-600 hover:text-blue-800">
                                    View Original
                                </a>
                            @endif
                        </div>
                    </header>
                    
                    <div class="prose prose-lg max-w-none mb-8">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </article>
                
                <!-- Comments Section -->
                <div class="border-t border-gray-200 p-6">
                    <h3 class="text-xl font-semibold mb-4">
                        Comments ({{ $article->comments->count() }})
                    </h3>
                    
                    @forelse($article->comments as $comment)
                        <div class="border-b border-gray-100 pb-4 mb-4 last:border-b-0">
                            <div class="flex items-center mb-2">
                                <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                <span class="text-gray-500 text-sm ml-2">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">No comments yet.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Back to Articles -->
            <div class="mt-6">
                <a href="{{ route('articles.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ← Back to Articles
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 