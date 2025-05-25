<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Ad') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.ads.show', $ad) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    View Ad
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

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-red-800 font-medium">Error!</h3>
                            <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Edit Ad</h3>
                        <p class="text-sm text-gray-500 mt-1">Update ad information</p>
                    </div>

                    <form action="{{ route('admin.ads.update', $ad) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $ad->title) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($ad->image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Current Image</label>
                                <div class="mt-1">
                                    <img src="{{ Storage::url($ad->image) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="h-32 w-auto object-cover rounded-lg border border-gray-300">
                                </div>
                            </div>
                        @endif

                        <!-- New Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                {{ $ad->image ? 'Replace Image (optional)' : 'Image' }}
                            </label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   {{ !$ad->image ? 'required' : '' }}>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target URL -->
                        <div>
                            <label for="target_url" class="block text-sm font-medium text-gray-700">Target URL</label>
                            <input type="url" 
                                   name="target_url" 
                                   id="target_url" 
                                   value="{{ old('target_url', $ad->target_url) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('target_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <select name="position" 
                                    id="position" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="">Select Position</option>
                                <option value="header" {{ old('position', $ad->position) == 'header' ? 'selected' : '' }}>Header</option>
                                <option value="footer" {{ old('position', $ad->position) == 'footer' ? 'selected' : '' }}>Footer</option>
                            </select>
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active From -->
                        <div>
                            <label for="active_from" class="block text-sm font-medium text-gray-700">Active From</label>
                            <input type="datetime-local" 
                                   name="active_from" 
                                   id="active_from" 
                                   value="{{ old('active_from', $ad->active_from->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('active_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active To -->
                        <div>
                            <label for="active_to" class="block text-sm font-medium text-gray-700">Active To</label>
                            <input type="datetime-local" 
                                   name="active_to" 
                                   id="active_to" 
                                   value="{{ old('active_to', $ad->active_to->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('active_to')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h4>
                            <div class="flex space-x-3">
                                <button type="button" 
                                        onclick="activateNow()" 
                                        class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Activate Now
                                </button>
                                <button type="button" 
                                        onclick="deactivate()" 
                                        class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.ads.show', $ad) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                Update Ad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function activateNow() {
            const now = new Date();
            const oneYearLater = new Date(now.getFullYear() + 1, now.getMonth(), now.getDate());
            
            document.getElementById('active_from').value = now.toISOString().slice(0, 16);
            document.getElementById('active_to').value = oneYearLater.toISOString().slice(0, 16);
        }

        function deactivate() {
            const pastDate = new Date('2020-01-01');
            
            document.getElementById('active_from').value = pastDate.toISOString().slice(0, 16);
            document.getElementById('active_to').value = pastDate.toISOString().slice(0, 16);
        }
    </script>
</x-app-layout> 