document.addEventListener('DOMContentLoaded', function () {
    let selectedUserId = null;

    // Open Chat for Selected User
    window.openChat = function (userId, userName) {
        selectedUserId = userId;
        document.getElementById('chat-user-name').innerText = userName;
        document.getElementById('messages').innerHTML = ''; // Clear previous chat
        loadMessages(userId);
    };

    // Load Messages for Selected User
    function loadMessages(userId) {
        axios.get(`/chat/messages/${userId}`)
            .then(response => {
                const messagesDiv = document.getElementById('messages');
                messagesDiv.innerHTML = ''; // Clear old messages

                response.data.forEach(msg => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('mb-2', 'p-2', 'rounded-md', 'max-w-[75%]');

                    if (msg.sender_id === parseInt('{{ auth()->id() }}')) {
                        messageElement.classList.add('bg-blue-500', 'text-white', 'ml-auto', 'text-right');
                    } else {
                        messageElement.classList.add('bg-gray-200', 'text-black', 'mr-auto', 'text-left');
                    }

                    messageElement.innerText = msg.message;
                    messagesDiv.appendChild(messageElement);
                });

                messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll to latest message
            })
            .catch(error => console.error('Error loading messages:', error));
    }

    // Send Message
    document.getElementById('send-message').addEventListener('click', function () {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message === '' || selectedUserId === null) return;

        axios.post('/send-message', {
            recipient_id: selectedUserId,
            message
        })
            .then(response => {
                messageInput.value = '';
                appendMessage(response.data.message, true);
            })
            .catch(error => console.error('Error sending message:', error));
    });

    // Append Sent Message
    function appendMessage(msg, isSentByMe) {
        const messagesDiv = document.getElementById('messages');
        const messageElement = document.createElement('div');
        messageElement.classList.add('mb-2', 'p-2', 'rounded-md', 'max-w-[75%]');

        if (isSentByMe) {
            messageElement.classList.add('bg-blue-500', 'text-white', 'ml-auto', 'text-right');
        } else {
            messageElement.classList.add('bg-gray-200', 'text-black', 'mr-auto', 'text-left');
        }

        messageElement.innerText = msg.message;
        messagesDiv.appendChild(messageElement);
        messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll
    }

    // Real-time Updates with Laravel Echo
    window.Echo.private(`chat.${parseInt('{{ auth()->id() }}')}`)
        .listen('MessageSent', (event) => {
            if (selectedUserId === event.sender_id || selectedUserId === event.recipient_id) {
                appendMessage(event, event.sender_id === parseInt('{{ auth()->id() }}'));
            }
        });
});
