
<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
    <?php
        include APP_DIR.'views/templates/nav.php';
        ?> 

        <div class="flex h-screen pt-16">
            <!-- Sidebar -->
            <div class="w-1/4 bg-gray-900 border-r border-gray-700 flex flex-col">
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-4 text-gray-100">Chats</h2>
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Search friends" 
                            class="w-full pl-10 pr-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div id="friendsList" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-700">
                    <!-- Friends list will be populated here -->
                     
                </div>
            </div>

            <!-- Chat container -->
            <div class="flex-1 flex flex-col bg-gray-900">
                <!-- Chat header -->
                <div class="bg-gray-900 border-b border-gray-700 p-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <img id="selectedFriendAvatar" src="" alt="" class="w-10 h-10 rounded-full">
                        <h2 id="selectedFriendName" class="ml-3 text-lg font-semibold text-gray-100"><?php html_escape(get_fullname(get_user_id(), $friend['id'])); ?></h2>
                    </div>
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
                    <!-- Messages will be populated here -->
                </div>

                <!-- Message input -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const userId = <?= html_escape(get_user_id()); ?>

        $.ajax({
            url: '<?= site_url('user/get_friends')?>', // Update to your server path
            method: 'GET',
            data: { user_id: userId },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    console.log('Friends:', response);
                    response.forEach(friend => {
                        $('#friendsList').append(`
                            <div>
                                <img src="${friend.profile_photo || 'default-photo.jpg'}" alt="Profile Photo" width="50">
                                <p>${friend.firstname} ${friend.lastname}</p>
                                <p>${friend.email}</p>
                            </div>
                        `);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>
