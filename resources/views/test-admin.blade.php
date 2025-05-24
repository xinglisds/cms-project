<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Access Test') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Admin Access Test Page</h1>
                    
                    @auth
                        <div class="space-y-4">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="font-semibold text-green-800">User Information</h3>
                                <p class="text-green-700">Name: {{ Auth::user()->name }}</p>
                                <p class="text-green-700">Email: {{ Auth::user()->email }}</p>
                                <p class="text-green-700">Role: {{ Auth::user()->role ?? 'user' }}</p>
                                <p class="text-green-700">Is Admin: {{ Auth::user()->isAdmin() ? 'Yes' : 'No' }}</p>
                            </div>

                            @if(Auth::user()->isAdmin())
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-blue-800">Admin Access Granted</h3>
                                    <p class="text-blue-700">You have administrative privileges!</p>
                                    <div class="mt-4 space-x-4">
                                        <a href="{{ route('admin.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                            Go to Admin Panel
                                        </a>
                                        <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                                            Go to Admin Dashboard
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-red-800">Access Denied</h3>
                                    <p class="text-red-700">You do not have administrative privileges.</p>
                                    <p class="text-red-700">Trying to access /admin will result in a 403 error.</p>
                                </div>
                            @endif

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-800">Test Admin Access</h3>
                                <p class="text-gray-700 mb-4">Click the link below to test admin access protection:</p>
                                <a href="{{ route('admin.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                    Try to Access Admin Panel
                                </a>
                                <p class="text-xs text-gray-500 mt-2">
                                    Admin users will see the panel, regular users will get a 403 error.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h3 class="font-semibold text-yellow-800">Not Logged In</h3>
                            <p class="text-yellow-700">Please log in to test admin access.</p>
                            <div class="mt-4 space-x-4">
                                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Register
                                </a>
                            </div>
                        </div>
                    @endauth

                    <div class="mt-6 bg-gray-100 border border-gray-300 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800">Test Credentials</h3>
                        <div class="mt-2 space-y-2 text-sm text-gray-600">
                            <div>
                                <strong>Admin User:</strong><br>
                                Email: tester1@gmail.com<br>
                                Password: password<br>
                                Role: admin
                            </div>
                            <div>
                                <strong>Regular User:</strong><br>
                                Email: user@example.com<br>
                                Password: password<br>
                                Role: user
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 