<div class="chat-container flex h-screen bg-gray-100">
    <!-- User List -->
    <div class="w-1/4 border-r border-gray-300 p-4 bg-white shadow-md">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Users</h2>
        <ul class="space-y-2">
            @foreach($users as $user)
                <li 
                    wire:click="selectUser({{ $user->id }})"
                    class="p-3 cursor-pointer rounded-lg shadow-sm hover:bg-gray-200 transition-all {{ $recipient_id == $user->id ? 'bg-gray-300' : 'bg-white' }} text-gray-900 font-medium"
                >
                    {{ $user->name }}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col bg-gray-50">
        @if($recipient_id)
            <!-- Shared Posts -->
            <div id="shared-posts" class="flex-1 overflow-y-auto p-4 space-y-4">
                @foreach($sharedPosts as $sharedPost)
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="text-sm text-gray-600">Shared by {{ $sharedPost->user->name }}</p>
                        <p class="mt-2">{{ $sharedPost->post->content }}</p>
                        @if($sharedPost->post->image)
                            <img src="{{ asset('storage/' . $sharedPost->post->image) }}" alt="Shared Post Image" class="mt-2 rounded-lg">
                        @endif
                        @if($sharedPost->post->video)
                            <video controls class="mt-2 rounded-lg">
                                <source src="{{ asset('storage/' . $sharedPost->post->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs px-4 py-2 rounded-lg shadow-md 
                            {{ $message->sender_id == Auth::id() ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-800' }}">
                            <!-- Message Content -->
                            <p class="break-words text-sm">{{ $message->message }}</p>
                            <!-- Message Time -->
                            <span class="text-xs opacity-75 mt-1 block text-gray-400">
                                {{ $message->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-300 p-4 bg-white shadow-md">
                <form wire:submit.prevent="sendMessage">
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            wire:model.defer="message"
                            placeholder="Type your message..."
                            class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-gray-800"
                            @disabled($isSending)
                        >
                        <button 
                            type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow-md hover:bg-blue-700 transition-all disabled:opacity-50"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Send</span>
                            <svg wire:loading class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('message') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </form>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center">
                <p class="text-gray-500 font-semibold">Select a user to start chatting</p>
            </div>
        @endif
    </div>
</div>