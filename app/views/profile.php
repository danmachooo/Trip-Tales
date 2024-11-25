
<?php
include APP_DIR.'views/templates/header.php';
?>
<body class="bg-gray-900 text-gray-100">
    <div id="app">
    <?php
        include APP_DIR.'views/templates/nav.php';
    ?> 
     <div id="app">
        <div class="container mx-auto pt-20 px-4">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 text-center mb-6 md:mb-0">
                        <img id="profileImage" src="https://via.placeholder.com/150" alt="Profile Picture" class="rounded-full w-32 h-32 mx-auto mb-4">
                        <h1 id="userName" class="text-2xl font-bold"></h1>
                        <p id="userEmail" class="text-gray-400"></p>
                        <button id="editProfileBtn" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">Edit Profile</button>
                    </div>
                    <div class="md:w-2/3 md:pl-6">
                        <h2 class="text-xl font-semibold mb-4">About Me</h2>
                        <p id="userBio" class="mb-4"></p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-semibold">Location</h3>
                                <p id="userLocation"></p>
                            </div>
                            <div>
                                <h3 class="font-semibold">Joined</h3>
                                <p id="userJoinDate"></p>
                            </div>
                            <div>
                                <h3 class="font-semibold">Birthday</h3>
                                <p id="userBirthday"></p>
                            </div>
                            <div>
                                <h3 class="font-semibold">Friends</h3>
                                <p id="userFriends"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts Section -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Recent Posts</h2>
                <div class="space-y-6" id="recentPosts">
                    <!-- Post items will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
            <form id="editProfileForm">
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-300">Name</label>
                    <input type="text" id="editName" name="name" class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label for="editBio" class="block text-sm font-medium text-gray-300">Bio</label>
                    <textarea id="editBio" name="bio" rows="3" class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                <div class="mb-4">
                    <label for="editLocation" class="block text-sm font-medium text-gray-300">Location</label>
                    <input type="text" id="editLocation" name="location" class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label for="editBirthday" class="block text-sm font-medium text-gray-300">Birthday</label>
                    <input type="date" id="editBirthday" name="birthday" class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition duration-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Simulated user data (replace with actual data fetching)
            let userData = {
                name: "John Doe",
                email: "john.doe@example.com",
                bio: "Passionate developer and tech enthusiast. Love creating innovative solutions and exploring new technologies.",
                location: "San Francisco, CA",
                joinDate: "January 2020",
                profileImage: "https://via.placeholder.com/150",
                birthday: "1990-04-15",
                friends: 287
            };

            function updateProfileDisplay() {
                $('#userName').text(userData.name);
                $('#userEmail').text(userData.email);
                $('#userBio').text(userData.bio);
                $('#userLocation').text(userData.location);
                $('#userJoinDate').text(userData.joinDate);
                $('#profileImage').attr('src', userData.profileImage);
                $('#userBirthday').text(new Date(userData.birthday).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }));
                $('#userFriends').text(userData.friends + " friends");
            }

            updateProfileDisplay();

            // Edit Profile functionality
            $('#editProfileBtn').click(function() {
                $('#editName').val(userData.name);
                $('#editBio').val(userData.bio);
                $('#editLocation').val(userData.location);
                $('#editBirthday').val(userData.birthday);
                $('#editProfileModal').removeClass('hidden').addClass('flex');
            });

            $('#cancelEditBtn').click(function() {
                $('#editProfileModal').removeClass('flex').addClass('hidden');
            });

            $('#editProfileForm').submit(function(e) {
                e.preventDefault();
                userData.name = $('#editName').val();
                userData.bio = $('#editBio').val();
                userData.location = $('#editLocation').val();
                userData.birthday = $('#editBirthday').val();
                updateProfileDisplay();
                $('#editProfileModal').removeClass('flex').addClass('hidden');
            });

            // Simulated recent posts data (replace with actual data fetching)
            const recentPosts = [
                {
                    id: 1,
                    title: "Exploring the Latest in AI Technology",
                    content: "Just finished a deep dive into GPT-4. The possibilities are endless!",
                    date: "2023-07-15",
                    likes: 42,
                    comments: 7
                },
                {
                    id: 2,
                    title: "Web Development Best Practices 2023",
                    content: "Sharing my thoughts on the most impactful web dev trends this year.",
                    date: "2023-07-10",
                    likes: 38,
                    comments: 5
                },
                {
                    id: 3,
                    title: "The Future of Remote Work in Tech",
                    content: "Reflecting on how remote work has transformed the tech industry.",
                    date: "2023-07-05",
                    likes: 56,
                    comments: 12
                }
            ];

            // Populate recent posts
            const $recentPosts = $('#recentPosts');
            recentPosts.forEach(post => {
                $recentPosts.append(`
                    <div class="bg-gray-700 rounded-lg p-4 relative" data-post-id="${post.id}">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">${post.title}</h3>
                            <div class="relative">
                                <button class="text-gray-400 hover:text-white focus:outline-none settings-toggle" aria-label="Post settings">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="settings-dropdown hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5">
                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white" role="menuitem">Edit Post</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white" role="menuitem">Delete Post</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-3">${post.content}</p>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>${post.date}</span>
                            <div>
                                <span class="mr-4"><i class="fas fa-heart"></i> ${post.likes}</span>
                                <span><i class="fas fa-comment"></i> ${post.comments}</span>
                            </div>
                        </div>
                    </div>
                `);
            });

            // Toggle settings dropdown
            $(document).on('click', '.settings-toggle', function(e) {
                e.stopPropagation();
                const dropdown = $(this).next('.settings-dropdown');
                $('.settings-dropdown').not(dropdown).addClass('hidden');
                dropdown.toggleClass('hidden');
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.settings-dropdown').length) {
                    $('.settings-dropdown').addClass('hidden');
                }
            });

            // Handle dropdown options (placeholder functionality)
            $(document).on('click', '.settings-dropdown a', function(e) {
                e.preventDefault();
                const action = $(this).text();
                const postId = $(this).closest('[data-post-id]').data('post-id');
                alert(`${action} for post ${postId}`);
                $('.settings-dropdown').addClass('hidden');
            });
        });
    </script>
       
</body>


