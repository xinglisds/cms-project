<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($articles as $article)
                            <article class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                @if($article->cover_image)
                                    <img src="{{ Storage::url($article->cover_image) }}" 
                                         alt="{{ $article->title }}"
                                         class="w-full h-48 object-cover rounded mb-4">
                                @endif
                                
                                <h3 class="text-lg font-semibold mb-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 mb-4">
                                    {{ Str::limit(strip_tags($article->content), 150) }}
                                </p>
                                
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                                    <span>{{ $article->comments_count }} comments</span>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No articles found.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-8">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 