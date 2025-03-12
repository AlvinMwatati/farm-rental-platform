<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Farm Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold">Welcome to Farm Rental</h1>
                    <p class="mt-2 text-gray-600">Easily browse and rent farm equipment.</p>
                    
                    <a href="{{ route('listings.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md">
                        View Listings
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
