<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($availableListings as $listing)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                    <span class="text-gray-700">No Image</span>
                </div>
            @endif
            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800">{{ $listing->name }}</h2>
                <p class="text-sm text-gray-600 mt-1">Condition: {{ $listing->condition }}</p>
                <p class="text-sm text-gray-600 mt-1">Location: {{ $listing->location }}</p>
                <p class="text-lg text-gray-800 font-bold mt-2">${{ $listing->price }}</p>
                <div class="mt-4">
                    <a href="{{ route('chat.start', ['user' => $listing->user_id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">
                        Contact Owner
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
