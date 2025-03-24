<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Chat with {{ $receiver->name }} --}}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <!-- Pass receiverId to the Livewire component -->
                @livewire('chat', ['recipientId' => isset($receiver) ? $receiver->id : null])

            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
