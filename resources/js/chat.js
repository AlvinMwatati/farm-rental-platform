document.addEventListener('DOMContentLoaded', function () {
    let selectedUserId = null;
    let authUserId = document.querySelector('meta[name="auth-user"]').getAttribute('content');

    // Make openChat globally accessible
    window.openChat = function (userId, userName) {
        selectedUserId = userId;
        document.getElementById('chat-header').innerText = `Chat with ${userName}`;
        loadMessages(userId);
    };

    function loadMessages(userId) {
        axios.get(`/messages/${userId}`)
            .then(response => {
                const messagesDiv = document.getElementById('messages');
                messagesDiv.innerHTML = '';

                response.data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('p-2', 'rounded-lg', 'max-w-xs', 'w-fit');

                    if (message.sender_id === parseInt(authUserId)) {
                        messageElement.classList.add('bg-blue-500', 'text-white', 'ml-auto', 'text-right');
                    } else {
                        messageElement.classList.add('bg-gray-300', 'text-black', 'mr-auto', 'text-left');
                    }

                    messageElement.innerHTML = `<strong>${message.sender_name}:</strong> ${message.message}`;
                    messagesDiv.appendChild(messageElement);
                });

                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            })
            .catch(error => console.error('Error loading messages:', error));
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

    document.getElementById('search-user').addEventListener('input', function () {
        let searchQuery = this.value;

        axios.get(`/chat?search=${searchQuery}`)
            .then(response => {
                let usersContainer = document.getElementById('users-container');
                usersContainer.innerHTML = '';

                response.data.forEach(user => {
                    let userElement = document.createElement('li');
                    userElement.classList.add('user-item', 'flex', 'items-center', 'space-x-3', 'p-3', 'rounded-lg', 'cursor-pointer', 'hover:bg-gray-200');

                    userElement.addEventListener('click', () => openChat(user.id, user.name));

                    userElement.innerHTML = `
                        <div class="w-10 h-10 bg-gray-300 flex items-center justify-center rounded-full">
                            ${user.name.charAt(0)}
                        </div>
                        <span>${user.name}</span>
                    `;

                    usersContainer.appendChild(userElement);
                });
            })
            .catch(error => console.error('Error fetching users:', error));
    });

    // Load the first user in the list by default
    setTimeout(() => {
        const firstUser = document.querySelector('.user-item');
        if (firstUser) {
            firstUser.click();
        }
    }, 500);

    // Listen for real-time messages using Laravel Echo
    if (typeof Echo !== 'undefined') {
        Echo.private(`chat.${authUserId}`)
            .listen('MessageSent', (event) => {
                if (selectedUserId === event.message.sender_id || selectedUserId === event.message.recipient_id) {
                    loadMessages(selectedUserId);
                }
            });
    } else {
        console.warn("Echo is not defined. WebSockets may not be working.");
    }
});
