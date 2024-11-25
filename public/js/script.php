<script>
const chatMessages = document.getElementById('chat-messages');
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message-input');
const chatList = document.getElementById('chat-list');

let currentChatId = null;
let socket;

function connectWebSocket() {
    socket = new WebSocket('ws://127.0.0.1:8080');

    socket.onopen = function(e) {
        console.log('Connected to WebSocket server');
    };

    socket.onmessage = function(event) {
        const data = JSON.parse(event.data);
        
        switch(data.type) {
            case 'chats':
                displayChats(data.data);
                break;
            case 'chat_messages':
                displayChatMessages(data.data);
                break;
            case 'new_message':
                addNewMessage(data.data);
                break;
            case 'message_seen':
                updateMessageSeen(data.data.messageId);
                break;
        }
    };

    socket.onclose = function(event) {
        if (event.wasClean) {
            console.log(`Connection closed cleanly, code=${event.code} reason=${event.reason}`);
        } else {
            console.log('Connection died');
        }
        // Attempt to reconnect after 5 seconds
        setTimeout(connectWebSocket, 5000);
    };

    socket.onerror = function(error) {
        console.log(`WebSocket error: ${error.message}`);
    };
}

function displayChats(chats) {
    chatList.innerHTML = '';
    chats.forEach(chat => {
        const chatElement = document.createElement('div');
        chatElement.classList.add('chat-item');
        chatElement.textContent = `Chat ${chat.id}`;
        chatElement.onclick = () => loadChat(chat.id);
        chatList.appendChild(chatElement);
    });
}

function loadChat(chatId) {
    currentChatId = chatId;
    chatMessages.innerHTML = '';
    socket.send(JSON.stringify({
        type: 'fetch_messages',
        chatId: chatId
    }));
}

function displayChatMessages(messages) {
    chatMessages.innerHTML = '';
    messages.forEach(message => {
        displayMessage(message);
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function addNewMessage(message) {
    if (message.chat_id === currentChatId) {
        displayMessage(message);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

function displayMessage(message) {
    const messageElement = document.createElement('div');
    messageElement.classList.add('message', message.sender_id === userId ? 'sent' : 'received');
    messageElement.dataset.messageId = message.id;

    const textElement = document.createElement('span');
    textElement.textContent = message.message;
    messageElement.appendChild(textElement);

    const timeElement = document.createElement('small');
    timeElement.textContent = formatTimestamp(new Date(message.sent_at));
    timeElement.classList.add('timestamp');
    messageElement.appendChild(timeElement);

    if (message.sender_id !== userId && !message.seen) {
        const seenElement = document.createElement('span');
        seenElement.textContent = '✓';
        seenElement.classList.add('seen-status');
        messageElement.appendChild(seenElement);
    }

    chatMessages.appendChild(messageElement);
}

function updateMessageSeen(messageId) {
    const messageElement = document.querySelector(`.message[data-message-id="${messageId}"]`);
    if (messageElement) {
        const seenElement = messageElement.querySelector('.seen-status');
        if (seenElement) {
            seenElement.textContent = '✓✓';
        }
    }
}

function formatTimestamp(date) {
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (message && currentChatId) {
        socket.send(JSON.stringify({
            type: 'message',
            chatId: currentChatId,
            message: message
        }));
        messageInput.value = '';
    }
});

chatMessages.addEventListener('scroll', function() {
    if (chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 1) {
        const unseenMessages = chatMessages.querySelectorAll('.message.received:not(.seen)');
        unseenMessages.forEach(messageElement => {
            socket.send(JSON.stringify({
                type: 'mark_seen',
                messageId: messageElement.dataset.messageId
            }));
            messageElement.classList.add('seen');
        });
    }
});

const userId = <?$this->session->userdata('user_id')?>

// Initial connection
connectWebSocket();
</script>
