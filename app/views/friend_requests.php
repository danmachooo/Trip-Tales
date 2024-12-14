<?php
include APP_DIR.'views/templates/header.php';
?>
<body class="bg-gray-100">
    <div id="app">
    <?php
        include APP_DIR.'views/templates/nav.php';
    ?> 
    <div class="container mx-auto px-4 py-8">
        <!-- Friend Requests Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Friend Requests</h2>
                <button id="see-all-requests" class="text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                    See All
                </button>
            </div>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <?php if (empty($requests)): ?>
                    <div class="p-4 text-center text-gray-500">
                        <p class="text-lg">No friend requests available.</p>
                    </div>
                <?php else: ?>
                <ul class="divide-y divide-gray-200" id="friend-requests-list">
                    <?php foreach($requests as $index => $request): ?>
                    <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out <?= $index >= 3 ? 'hidden' : '' ?>" id="request-<?= $request['id'] ?>">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover" src="<?= $request['profile_photo'] ?>" alt="Profile picture">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    <?= $request['firstname'] ?> <?= $request['lastname'] ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= $request['sent_at'] ?>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="accept-btn px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 ease-in-out" data-id="<?= $request['id'] ?>">
                                    Accept
                                </button>
                                <button class="decline-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-300 ease-in-out" data-id="<?= $request['id'] ?>">
                                    Decline
                                </button>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- TripTales Users Section -->
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">TripTales Users</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if (!empty($users)): ?>
                    <?php 
                    $hasUsersToDisplay = false; // Flag to check if there are users to display
                    foreach ($users as $user): 
                        // Exclude users who are 'Friend' or have a 'Pending Request' status
                        if ($user['relationship_status'] !== 'Friend' && $user['relationship_status'] !== 'Pending Approval'): 
                            $hasUsersToDisplay = true; // At least one user to display
                    ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        <img class="w-full h-48 object-cover" src="<?= ($user['profile_photo']) ?>" alt="<?= ($user['firstname']) ?>'s profile">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2"><?= ($user['firstname']) ?> <?= ($user['lastname']) ?></h3>
                            <button class="add-friend-btn w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out" data-id="<?= htmlspecialchars($user['id']) ?>">
                                Add Friend
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php if (!$hasUsersToDisplay): // If no users passed the filter ?>
                        <div class="p-4 text-center text-gray-500"><p class="text-lg">No User Available.</p></div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-gray-500"><p class="text-lg">No User Available.</p></div>
                <?php endif; ?>
            </div>
        </div>




        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle See All button click
            $('#see-all-requests').on('click', function() {
                $('#friend-requests-list li').removeClass('hidden');
                $(this).addClass('hidden');
            });

            // Handle Accept Button Click
            $('.accept-btn').on('click', function () {
                const requestId = $(this).data('id');
                $.ajax({
                    url: '/friend-requests/accept',
                    method: 'POST',
                    data: { id: requestId },
                    success: function (response) {
                        const parsedResponse = JSON.parse(response);
                        $(`#request-${requestId}`).remove();

                        if ($('#friend-requests-list').children().length === 0) {
                            $('#friend-requests-list').parent().html('<div class="p-4 text-center text-gray-500"><p class="text-lg">No friend requests available.</p></div>');
                        }

                        alert(parsedResponse.message || "Friend request accepted.");
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while accepting the request.");
                    }
                });
            });

            // Handle Decline Button Click
            $('.decline-btn').on('click', function () {
                const requestId = $(this).data('id');
                $.ajax({
                    url: '/friend-requests/decline',
                    method: 'POST',
                    data: { id: requestId },
                    success: function (response) {
                        const parsedResponse = JSON.parse(response);
                        $(`#request-${requestId}`).remove();

                        if ($('#friend-requests-list').children().length === 0) {
                            $('#friend-requests-list').parent().html('<div class="p-4 text-center text-gray-500"><p class="text-lg">No friend requests available.</p></div>');
                        }

                        alert(parsedResponse.message || "Friend request declined.");
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while declining the request.");
                    }
                });
            });

            // Handle Add Friend Button Click
            $('.add-friend-btn').on('click', function () {
                const userId = $(this).data('id');
                $.ajax({
                    url: '/friend-requests/send',
                    method: 'POST',
                    data: { id: userId },
                    success: function (response) {
                        const parsedResponse = JSON.parse(response);
                        alert(parsedResponse.message || "Friend request sent.");
                        // Optionally, you can update the button state or remove the user from the list
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while sending the friend request.");
                    }
                });
            });
        });
    </script>
</body>