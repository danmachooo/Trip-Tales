
<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
    <?php
        include APP_DIR.'views/templates/nav.php';
        ?> 

        <div class="flex h-screen pt-16 bg-gray-800">
            <!-- Sidebar -->
            <div class="w-1/4 bg-gray-900 border-r border-gray-700 flex flex-col p-4">
                <!-- Sidebar Title -->
                <h2 class="text-xl font-semibold mb-4 text-gray-100">Chats</h2>
                
                <!-- Search Box -->
                <div class="relative mb-4">
                    <input 
                        type="text" 
                        placeholder="Search friends" 
                        class="w-full pl-10 pr-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Friends List -->
                <div id="friendsList" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-700">
                    <?php foreach($friends as $friend): ?>
                    <a href="<?= site_url('chat/' . $friend['id']) ?>" class="block">
                        <div class="flex items-center mb-4 p-2 rounded-lg hover:bg-gray-700 cursor-pointer friend-item">
                            <img src="<?= $friend['profile_photo'] ?? 'https://picsum.photos/id/237/50' ?>" alt="Profile Photo" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <p class="text-gray-200 font-semibold"><?= html_escape($friend['firstname']) . ' ' . html_escape($friend['lastname']) ?></p>
                                <p class="text-gray-400 text-sm"><?= html_escape($friend['email']) ?></p>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Chat Container -->
            <div class="flex-1 flex flex-col bg-gray-900">
                <!-- Chat Header -->
                <div class="bg-gray-900 border-b border-gray-700 p-4 flex justify-between items-center">
                    <?php if (isset($recepient) && !empty($recepient)): ?>
                        <?php foreach($recepient as $r): ?>
                        <div class="flex items-center">
                            <img id="selectedFriendAvatar" src="<?= $r['profile_photo'] ?? 'https://picsum.photos/id/237/50' ?>" alt="Profile Photo" class="w-10 h-10 rounded-full">
                            <h2 id="selectedFriendName" class="ml-3 text-lg font-semibold text-gray-100">
                                <?= isset($r) ? $r['firstname'] . ' ' . $r['lastname'] : 'Select a friend' ?>
                            </h2>
                            <input type="hidden" id="selectedChatId" value="<?= $chat['id'] ?? '' ?>">
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h2 class="ml-3 text-lg font-semibold text-gray-100">No recipient selected</h2>
                    <?php endif; ?>

                    <div class="flex space-x-2">
                        <button class="p-2 rounded-full hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-phone text-gray-400 hover:text-blue-400"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-video text-gray-400 hover:text-blue-400"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-ellipsis-v text-gray-400 hover:text-blue-400"></i>
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                <div id="messagesContainer" class="flex-1 p-4 overflow-y-auto scrollbar-hide">
                    <?php if(isset($messages) && is_array($messages)): ?>
                        <?php foreach($messages as $message): ?>
                            <div class="mb-4 <?= $message['sender_id'] == $user_id ? 'text-right' : 'text-left' ?>">
                                <div class="inline-block p-2 rounded-lg <?= $message['sender_id'] == $user_id ? 'bg-blue-500 text-white' : 'bg-gray-700 text-gray-200' ?>">
                                    <?= html_escape($message['message']) ?>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?= date('M d, Y H:i', strtotime($message['sent_at'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500">No messages yet. Start a conversation!</p>
                    <?php endif; ?>
                </div>
                <!-- Message Input -->
                <form id="messageForm" class="bg-gray-800 border-t border-gray-700 p-4">
                    <div class="flex items-center">
                        <input 
                            type="text" 
                            id="messageInput" 
                            placeholder="Type a message..." 
                            class="flex-1 mr-2 p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition duration-200"
                        >
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

<<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        var message = $('#messageInput').val();
        var chatId = $('#selectedChatId').val();

        if (message.trim() === '' || !chatId) {
            return;
        }

        $.ajax({
            url: '<?= site_url('chat/send-message') ?>',
            method: 'POST',
            data: {
                chat_id: chatId,
                message: message
            },
            success: function(response) {
                var parsedResponse = JSON.parse(response);
                if (parsedResponse.success) {
                    var newMessage = `
                        <div class="mb-4 text-right">
                            <div class="inline-block p-2 rounded-lg bg-blue-500 text-white">
                                ${message}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Just now
                            </div>
                        </div>
                    `;
                    $('#messagesContainer').append(newMessage);
                    $('#messageInput').val('');
                    
                    // Scroll to the bottom of the messages container
                    $('#messagesContainer').scrollTop($('#messagesContainer')[0].scrollHeight);
                } else {
                    console.error('Error sending message:', parsedResponse.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
            }
        });
    });
});
</script>