@php
use App\Models\Ad;

// Support custom display limit, default is 3
$limit = $limit ?? 3;
$position = $position ?? 'header';

$ads = Ad::active()
    ->byPosition($position)
    ->orderBy('id', 'asc')  // Sort by ID ascending
    ->limit($limit)
    ->get();

// Set different styles based on position
if ($position === 'header') {
    $bannerHeight = 'h-32';
    $containerPadding = 'p-4';
    $containerClass = 'mb-6';
    $itemSpacing = 'mb-6';
} else {
    $bannerHeight = 'h-16';
    $containerPadding = 'p-3';
    $containerClass = 'mb-4';
    $itemSpacing = 'mb-3';
}
@endphp

@if($ads->count() > 0)
    <div class="ad-container {{ $containerClass }}">
        <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Sponsored Ads</h3>
        
        @foreach($ads as $ad)
            <div class="ad-item {{ $itemSpacing }} {{ $containerPadding }} bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <a href="{{ $ad->target_url }}" 
                   target="_blank" 
                   rel="noopener noreferrer nofollow"
                   class="block hover:opacity-90 transition-opacity">
                    
                    @if($ad->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($ad->image) }}" 
                                 alt="{{ $ad->title }}" 
                                 class="w-full {{ $bannerHeight }} object-cover rounded border bg-gray-100">
                        </div>
                    @endif
                    
                    <div class="px-1">
                        <h4 class="font-medium text-gray-800 text-sm mb-2 line-clamp-2">{{ $ad->title }}</h4>
                        
                        <div class="flex justify-between items-center">
                            <span class="inline-block text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                Ad
                            </span>
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        
        <!-- Display ad count information -->
        @if($ads->count() >= $limit)
            <div class="text-center mt-4">
                <p class="text-xs text-gray-500">Showing latest {{ $ads->count() }} ads</p>
            </div>
        @elseif($ads->count() > 0)
            <div class="text-center mt-4">
                <p class="text-xs text-gray-500">{{ $ads->count() }} ads total</p>
            </div>
        @endif
    </div>
@endif 