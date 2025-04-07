<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Farm Rental') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="relative bg-cover bg-center h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('images/bdaa025e-b349-41bd-93f2-ff9fb9a23134.png') }}');">
                <div class="text-center bg-black bg-opacity-50 p-6 rounded-lg">
                    <h1 class="text-4xl font-bold">Rent and Lease Farm Equipment with Ease</h1>
                    <p class="text-lg mt-2">Find the tools you need or earn by renting out your own.</p>
                    <a href="{{ route('listings.index') }}" class="mt-4 inline-block bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition">
                        Browse Listings
                    </a>
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6 p-6">
                <h3 class="text-lg font-semibold">How It Works</h3>
                <p class="text-gray-600 mt-2">We connect farm owners with renters looking for high-quality equipment.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">1. Browse Listings</h4>
                        <p class="text-gray-600 mt-1">Find farm equipment available for rent near you.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">2. Contact the Owner</h4>
                        <p class="text-gray-600 mt-1">Message the owner directly through our platform.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">3. Rent & Enjoy</h4>
                        <p class="text-gray-600 mt-1">Get the equipment and start your work hassle-free.</p>
                    </div>
                </div>
            </div>

            <!-- Featured Listings Section -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6 p-6">
                <h3 class="text-lg font-semibold">Featured Listings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    @foreach($listings as $listing)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            @if($listing->image)
                                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-700">No Image</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $listing->name }}</h3>
                                <p class="text-gray-600">Location: {{ $listing->location }}</p>
                                <p class="text-lg font-bold mt-2">Ksh {{ $listing->price }} per day</p>
                                <a href="{{ route('chat.start', ['user' => $listing->user_id]) }}" class="block bg-blue-500 text-white text-center py-2 rounded mt-3 hover:bg-blue-600 transition">
                                    Contact Owner
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-6">
                    <a href="{{ route('listings.index') }}" class="text-blue-600 font-semibold hover:underline">View All Listings</a>
                </div>
            </div>

            <!-- Newsletter Signup Section -->
            <div class="bg-gray-200 py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
                    <h3 class="text-lg font-semibold">Stay Updated!</h3>
                    <p class="text-gray-600 mt-2">Sign up for our newsletter and receive the latest equipment rental deals and news.</p>
                    <form class="mt-4 flex justify-center gap-2">
                        <input type="email" placeholder="Your Email" class="border p-2 rounded-lg">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Interactive Map Section -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h3 class="text-lg font-semibold text-center">Find Equipment Near You</h3>
                    <div class="w-full h-96 mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=YOUR_GOOGLE_MAPS_EMBED_URL_HERE" class="w-full h-full rounded-lg" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <!-- Blog Section -->
            <div class="py-12 bg-white">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h3 class="text-lg font-semibold text-center">Our Latest Blog Posts</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg">How to Maintain Your Farm Equipment</h4>
                            <p class="text-gray-600 mt-1">Learn the best practices for keeping your equipment in top condition...</p>
                            <a href="#" class="text-blue-600 hover:underline">Read More</a>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg">Top Farm Equipment for 2025</h4>
                            <p class="text-gray-600 mt-1">Explore the most recommended equipment for the upcoming year...</p>
                            <a href="#" class="text-blue-600 hover:underline">Read More</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Farm Rental. All rights reserved.</p>
            <div class="mt-4">
                <a href="https://facebook.com" target="_blank" class="text-blue-600 hover:underline mx-2">Facebook</a>
                <a href="https://twitter.com" target="_blank" class="text-blue-400 hover:underline mx-2">Twitter</a>
                <a href="https://instagram.com" target="_blank" class="text-pink-500 hover:underline mx-2">Instagram</a>
            </div>
        </div>
    </footer>
    @endsection
</x-app-layout>
