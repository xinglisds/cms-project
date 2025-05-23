@props(['article'])

<article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
    @if($article->cover_image)
        <img src="{{ Storage::url($article->cover_image) }}" 
             alt="{{ $article->title }}"
             class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    @endif
    
    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3 line-clamp-2">
            <a href="{{ route('articles.show', $article->slug) }}" 
               class="hover:text-blue-600 transition-colors duration-200">
                {{ $article->title }}
            </a>
        </h3>
        
        <p class="text-gray-600 mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($article->content), 120) }}
        </p>
        
        <div class="flex justify-between items-center text-sm text-gray-500">
            <time datetime="{{ $article->created_at->toISOString() }}">
                {{ $article->created_at->format('M d, Y') }}
            </time>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                {{ $article->comments_count ?? 0 }}
            </span>
        </div>
        
        @if($article->is_imported)
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                External Source
            </div>
        @endif
    </div>
</article> 