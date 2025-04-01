<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome & Summary Section -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600">Here’s a quick overview of your account and activity:</p>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Active Listings</h4>
                        <p class="text-2xl font-bold">{{ auth()->user()->listings()->count() }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Messages</h4>
                        <p class="text-2xl font-bold">{{ auth()->user()->messages()->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Forum Posts</h4>
                        <p class="text-2xl font-bold">{{ auth()->user()->posts()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('listings.index') }}" class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-gray-100 transition">
                    <h3 class="text-xl font-bold">Listings</h3>
                    <p class="text-gray-600 mt-2">Browse or manage your equipment listings.</p>
                </a>
                <a href="{{ route('chat.index') }}" class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-gray-100 transition">
                    <h3 class="text-xl font-bold">Chat</h3>
                    <p class="text-gray-600 mt-2">Connect with other users.</p>
                </a>
                <a href="{{ route('forum') }}" class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-gray-100 transition">
                    <h3 class="text-xl font-bold">Forum</h3>
                    <p class="text-gray-600 mt-2">Join discussions and share ideas.</p>
                </a>
            </div>

            <!-- Recent Activity Section -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                <!-- Example of recent posts or messages. Replace with dynamic content as needed. -->
                <ul class="divide-y divide-gray-200">
                    <li class="py-2">No recent messages.</li>
                </ul>
            </div>

            <!-- Announcements Section -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Announcements</h3>
                <p class="text-gray-600">No new announcements at the moment. Check back later!</p>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
