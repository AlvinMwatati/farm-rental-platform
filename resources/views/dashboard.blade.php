<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content') <!-- ✅ Wrap all content inside this -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            
            <!-- Site Preview Section -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6 p-6">
                <h3 class="text-lg font-semibold">Site Preview</h3>
                <p>Welcome to Farm Rental! Browse and rent farm equipment easily.</p>
                <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Go to Home</a>
            </div>

            <!-- User Listings Navigation -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6 p-6">
                <h3 class="text-lg font-semibold">Your Listings</h3>
                <a href="{{ route('listings.index') }}" class="text-blue-600 hover:underline">View Your Listings</a>
            </div>
        </div>
    </div>
    @endsection <!-- ✅ Close the section -->
</x-app-layout>
