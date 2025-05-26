<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Panel') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <h1 class="text-2xl font-bold text-gray-900">Welcome to Admin Panel</h1>
                    </div>
                    <p class="text-gray-600 mb-4">
                        You have administrative access to manage the CMS system. Use the navigation below to access different management areas.
                    </p>
                    
                    <!-- Quick Actions Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <!-- Articles Management -->
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-black-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="font-semibold text-blue-900">Articles</h3>
                            </div>
                            <p class="text-blue-700 text-sm mb-3">Manage all articles and content</p>
                            <a href="{{ route('admin.articles') }}" class="inline-flex items-center text-black hover:text-gray-800 text-sm font-medium">
                                Manage Articles
                                <svg class="ml-1 w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Ad Management -->
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-black-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="font-semibold text-green-900">Ads</h3>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Upload and manage advertisements</p>
                            <a href="{{ route('admin.ads.index') }}" class="inline-flex items-center text-black hover:text-gray-800 text-sm font-medium">
                                Manage Ads
                                <svg class="ml-1 w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Comments Management -->
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-black-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <h3 class="font-semibold text-orange-900">Comments</h3>
                            </div>
                            <p class="text-orange-700 text-sm mb-3">Moderate user comments</p>
                            <a href="{{ route('admin.comments') }}" class="inline-flex items-center text-black hover:text-gray-800 text-sm font-medium">
                                Manage Comments
                                <svg class="ml-1 w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- System Info -->
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-black-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <h3 class="font-semibold text-purple-900">Dashboard</h3>
                            </div>
                            <p class="text-purple-700 text-sm mb-3">View system statistics</p>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-black hover:text-gray-800 text-sm font-medium">
                                View Dashboard
                                <svg class="ml-1 w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Newsletter Management -->
                        <div class="bg-pink-50 rounded-lg p-4 border border-pink-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-black-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="font-semibold text-pink-900">Newsletters</h3>
                            </div>
                            <p class="text-pink-700 text-sm mb-3">Manage newsletter subscriptions</p>
                            <a href="{{ route('admin.subscribers') }}" class="inline-flex items-center text-black hover:text-gray-800 text-sm font-medium">
                                Manage Newsletters
                                <svg class="ml-1 w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Information -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-amber-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-amber-800 font-medium">Admin Access Confirmed</h3>
                        <p class="text-amber-700 text-sm mt-1">
                            You are currently logged in as <strong>{{ Auth::user()->name }}</strong> with admin privileges. 
                            This area is protected and only accessible to administrators.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 