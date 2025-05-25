<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Ad') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.ads.edit', $ad) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Edit Ad
                </a>
                <a href="{{ route('admin.ads.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Back to Ads
                </a>
                <a href="{{ route('admin.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Back to Admin Panel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-green-800 font-medium">Success!</h3>
                            <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Ad Details</h3>
                        <p class="text-sm text-gray-500 mt-1">View ad information</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Ad Information -->
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->title }}</p>
                            </div>

                            <!-- Target URL -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target URL</label>
                                <a href="{{ $ad->target_url }}" 
                                   target="_blank" 
                                   class="mt-1 text-sm text-blue-600 hover:text-blue-800 break-all">
                                    {{ $ad->target_url }}
                                    <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>

                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Position</label>
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($ad->position) }}
                                </span>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-1">
                                    @if($ad->isActive())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Active Period -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Active Period</label>
                                <div class="mt-1 text-sm text-gray-900">
                                    <div>From: {{ $ad->active_from->format('F j, Y g:i A') }}</div>
                                    <div>To: {{ $ad->active_to->format('F j, Y g:i A') }}</div>
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->created_at->format('F j, Y g:i A') }}</p>
                            </div>

                            @if($ad->updated_at != $ad->created_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $ad->updated_at->format('F j, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Ad Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Image</label>
                            @if($ad->image)
                                <div class="border border-gray-300 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($ad->image) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-auto object-cover">
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No image uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 mt-8">
                        <a href="{{ route('admin.ads.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Back to List
                        </a>
                        <a href="{{ route('admin.ads.edit', $ad) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Edit Ad
                        </a>
                        <form action="{{ route('admin.ads.destroy', $ad) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this ad?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                Delete Ad
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 