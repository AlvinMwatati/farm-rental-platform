<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat with Other Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex">

                    <!-- Sidebar: List of Users -->
                    <div class="w-1/4 border-r p-4 h-96 overflow-y-scroll">
                        <h3 class="text-lg font-semibold mb-4">Users</h3>
                        <ul>
                            @foreach($users as $user)
                                <li class="p-2 border-b hover:bg-gray-200 cursor-pointer"
                                    onclick="openChat({{ $user->id }}, '{{ $user->name }}')">
                                    {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Chat Window -->
                    <div class="w-3/4 p-4 flex flex-col">
                        <h3 class="text-lg font-semibold" id="chat-header">Select a user to chat</h3>

                        <!-- Chat Messages -->
                        <div id="messages" class="border p-4 h-64 overflow-y-scroll bg-gray-100 rounded-md flex flex-col space-y-2">
                            <!-- Messages will be loaded here -->
                        </div>

                        <!-- Chat Input -->
                        <div class="flex mt-4">
                            <input type="text" id="message-input" placeholder="Type your message..."
                                class="flex-1 border px-4 py-2 rounded-l-md">
                            <button id="send-message" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition">
                                Send
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let selectedUserId = null;
    let authUserId = {{ Auth::id() }};

    function openChat(userId, userName) {
        selectedUserId = userId;
        document.getElementById('chat-header').innerText = `Chat with ${userName}`;
        loadMessages(userId);
    }

    function loadMessages(userId) {
        axios.get(`/messages/${userId}`).then(response => {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = '';
            response.data.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.classList.add('p-2', 'rounded-md', 'max-w-xs');

                if (message.sender_id === authUserId) {
                    messageElement.classList.add('bg-blue-500', 'text-white', 'ml-auto', 'text-right');
                } else {
                    messageElement.classList.add('bg-gray-300', 'text-black', 'mr-auto', 'text-left');
                }

                messageElement.innerHTML = `<strong>${message.sender_name}:</strong> ${message.message}`;
                messagesDiv.appendChild(messageElement);
            });

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });
    }

    document.getElementById('send-message').addEventListener('click', function () {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();
        if (message === '' || !selectedUserId) return;

        axios.post('/send-message', { recipient_id: selectedUserId, message: message })
            .then(response => {
                messageInput.value = '';
                loadMessages(selectedUserId);
            })
            .catch(error => console.error('Error sending message:', error));
    });
</script>
