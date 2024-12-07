<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
        <?php
        include APP_DIR.'views/templates/nav.php';
        ?>  
        <div class="container mx-auto px-4 mt-20">
            <div class="flex justify-center">
                <!-- Main Feed -->
                <div class="md:w-2/3 space-y-6">
                    <!-- Post Creator Trigger -->
                    <div id="post-creator-trigger" class="bg-gray-800 rounded-lg p-4 cursor-pointer hover:bg-gray-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-600"></div>
                            <div class="flex-1">
                                <input readonly placeholder="What's on your mind, <?= html_escape(get_fullname(get_user_id())); ?>?" class="w-full bg-gray-700 border-none text-white placeholder-gray-400 p-2 rounded">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div id="post-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center transition-opacity duration-300 ease-in-out">
                        <div class="modal-overlay absolute w-full h-full bg-black opacity-50 z-40"></div>
                        <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded-lg shadow-xl z-50 overflow-y-auto max-h-[90vh] p-8 transition-all transform scale-95 opacity-0 modal-appear">
                        <form id="entry-form" enctype="multipart/form-data">
                            <div class="modal-content border-0">
                                <!-- Header Section -->
                                <div class="flex justify-between items-center pb-4 border-b border-0-gray-300 sticky top-0 bg-white z-1">
                                <p class="text-2xl font-semibold text-gray-800">Create Post</p>
                                    <div class="modal-close cursor-pointer text-gray-600 hover:text-gray-800 transition duration-300">
                                        <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Post Content Section -->
                                <div class="space-y-6 border-0">
                                    <textarea id="description" name="description" class="w-full p-4 border border-gray-300 rounded-lg resize-none bg-gray-50 text-gray-700 placeholder-gray-400  focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" rows="4" placeholder="What's on your mind?"></textarea>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Tags</label>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                            <?php foreach ($tags as $tag): ?>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="tag-<?= $tag['id']; ?>" name="tags[]" value="<?= $tag['id']; ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                <label for="tag-<?= $tag['id']; ?>" class="ml-2 text-sm text-gray-700"><?= $tag['name']; ?></label>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <!-- Image Upload Section -->
                                    <div class="space-y-4">
                                        <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                                        <label for="image-upload" class="cursor-pointer bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                                            Choose Image
                                        </label>
                                        <input type="file" size="20" id="image-upload" name="image-upload" class="hidden" accept="image/*">

                                        <div id="image-preview" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                            <span>Image Preview</span>
                                        </div>

                                        <!-- Map Section -->
                                        <div id="map-container" class="hidden space-y-4">
                                            <div id="map" class="w-full h-64 bg-gray-200 rounded-lg"></div>
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">Enter Location</label>
                                                <div class="flex gap-2">
                                                    <input id="location-input" name="destination" placeholder="Search for a location" class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                                    <button id="location-btn" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                                        Share Location
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex justify-between">
                                        <button id="toggle-map" type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                            Add Location
                                        </button>
                                        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <!-- Post -->
                    <?php foreach ($posts as $post): ?>
                        <input type="hidden" id="latitude" name="latitude" value="<?=$post['latitude']?>">
                        <input type="hidden" id="longitude" name="longitude" value="<?=$post['longitude']?>">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                                <div>
                                    <h3 class="font-bold"><?= $post['firstname'] ?> <?= $post['lastname'] ?> is in <?=$post['destination']?></h3>
                                    <p class="text-sm text-gray-500"><?=$post['posted_date']?></p>
                                </div>
                            </div>
                            <p class="mb-4"><?=$post['description']?></p>

                            <!-- Convert tags to hashtags -->
                            <?php 
                                // If the tags are not empty
                                if (!empty($post['tags'])): 
                                    // Split the tags by commas
                                    $tags = explode(', ', $post['tags']);
                                    // Display each tag as a hashtag
                                    foreach ($tags as $tag): 
                                        echo '<span class="text-blue-500 font-semibold">#' . htmlspecialchars($tag) . ' </span>';
                                    endforeach;
                                endif;
                            ?>

                             <!-- Photo of the Post -->
                             <?php if (!empty($post['photo_url'])): ?>
                                <div class="mb-4">
                                    <img 
                                        src="\public\<?= htmlspecialchars($post['photo_url']) ?>" 
                                        alt="Post Image" 
                                        class="w-full h-64 object-cover rounded-lg"
                                    />
                                </div>
                            <?php endif; ?>

                            <!-- New Map Area -->
                            <div class="mb-4">
                                <h4 class="font-bold mb-2">Location</h4>
                                <div id="map-<?= $post['entry_id'] ?>" class="bg-gray-200 rounded-lg h-48 flex z-0 items-center justify-center">
                                    <!-- <p class="text-gray-500">Map of Bali will be displayed here</p> -->
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <button class="like-button flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors duration-200" 
                                        data-entry-id="<?= $post['entry_id'] ?>"
                                        data-liked="<?= $post['is_liked'] ? 'true' : 'false' ?>">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span class="like-count" data-entry-id="<?= $post['entry_id'] ?>"><?=$post['like_count']?></span> Likes
                                </button>
                                <button class="text-gray-600 hover:text-blue-600" id="showComments">
                                    <span id="commentCount"><?=count( $post['comments'])?></span> Comments
                                </button>
                            </div>
                            <div id="commentSection-<?= $post['entry_id'] ?>" class="mt-4">
                                <div class="border-t pt-4 mb-4">
                                    <h4 class="font-bold mb-2">Comments</h4>
                                    <ul id="commentList-<?= $post['entry_id'] ?>" class="space-y-2">
                                        <?php if (!empty($post['comments'])): ?>
                                            <?php foreach ($post['comments'] as $comment): ?>
                                                <li class="border-b pb-2">
                                                    <strong><?= $comment['firstname'] ?> <?= $comment['lastname'] ?>:</strong>
                                                    <p><?= htmlspecialchars($comment['comment']) ?></p>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li>No comments yet.</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <form class="comment-form flex gap-2" data-entry-id="<?= $post['entry_id'] ?>">
                                    <input type="text" name="comment" placeholder="Add a comment..." class="flex-grow p-2 border rounded-lg" required>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Post</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>


                    
                </div>
            </div>
        </div>
    </div>


</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Leaflet.js CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
// Modal Functionality
const openModal = document.getElementById('post-creator-trigger');
const modal = document.querySelector('.modal');
const closeModalBtn = document.querySelector('.modal-close');
const overlay = document.querySelector('.modal-overlay');
const form = document.getElementById('entry-form');
const mapContainer = document.getElementById('map-container');
const toggleMapButton = document.getElementById('toggle-map');

// Open Modal
openModal.addEventListener('click', () => {
    modal.classList.remove('opacity-0', 'pointer-events-none');
    document.body.classList.add('modal-active');
    setTimeout(() => {
        modal.querySelector('.modal-container').classList.remove('scale-95', 'opacity-0');
    }, 100); // Delay to make the scaling effect visible
});

// Close Modal with Confirmation
const closeModal = () => {
    const confirmClose = confirm('Are you sure you want to close this form? All entered data will be lost.');
    if (confirmClose) {
        form.reset();
        $('#image-preview').html('<span>Image Preview</span>');

        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }

        if (!mapContainer.classList.contains('hidden')) {
            mapContainer.classList.add('hidden');
            toggleMapButton.textContent = 'Add Location';
        }

        modal.querySelector('.modal-container').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('modal-active');
        }, 300);
    }
};

closeModalBtn.addEventListener('click', closeModal);
overlay.addEventListener('click', closeModal);

// Map Functionality
let map = null;
let marker = null;

document.getElementById('toggle-map').addEventListener('click', () => {
    const mapContainer = document.getElementById('map-container');
    const toggleBtn = document.getElementById('toggle-map');

    if (mapContainer.classList.contains('hidden')) {
        mapContainer.classList.remove('hidden');
        toggleBtn.textContent = 'Hide Map';
        initializeMap();
    } else {
        mapContainer.classList.add('hidden');
        toggleBtn.textContent = 'Add Location';
    }
});

// Initialize the map only once
const initializeMap = () => {
    if (!map) {
        map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        document.getElementById('location-btn').addEventListener('click', pinLocation);
    }
};

// Function to handle location pinning
const pinLocation = () => {
    const locationInput = document.getElementById('location-input').value;

    if (locationInput.trim()) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(locationInput)}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.length > 0) {
                    const latitude = parseFloat(data[0].lat);
                    const longitude = parseFloat(data[0].lon);
                    const locationName = data[0].display_name;

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([latitude, longitude]).addTo(map);
                    map.setView([latitude, longitude], 13);
                    marker.bindPopup(locationName).openPopup();

                    console.log('Location:', locationName, 'Lat:', latitude, 'Lng:', longitude);
                } else {
                    alert('Location not found. Try again.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Error finding location.');
            });
    } else {
        alert('Please enter a location.');
    }
};

// Image Upload Preview 
$('#image-upload').on('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').html(`<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">`);
        };
        reader.readAsDataURL(file);
    } else {
        $('#image-preview').html('<span>Image Preview</span>');
    }
});

// Form Submission with AJAX
$(document).ready(() => {
    // Toggle like
    $('.like-button').on('click', function() {
    const entryId = $(this).data('entry-id');
    const $button = $(this);
    const $likeCount = $('.like-count[data-entry-id="' + entryId + '"]');
    
    $.ajax({
        url: '<?= site_url("posts/toggle_like"); ?>',
        type: 'POST',
        data: { entry_id: entryId },
        success: function(response) {
            if (response.success) {
                $likeCount.text(response.data.like_count);
                
                // Toggle the liked state
                if ($button.data('liked') === 'true') {
                    $button.data('liked', 'false');
                    $button.removeClass('text-blue-600').addClass('text-gray-600');
                } else {
                    $button.data('liked', 'true');
                    $button.removeClass('text-gray-600').addClass('text-blue-600');
                }
            } else {
                alert(response.message);
            }
        }
    });
});
    // Add comment
    $('.comment-form').on('submit', function(e) {
        e.preventDefault();
        const entryId = $(this).data('entry-id');
        const comment = $(this).find('input[name="comment"]').val();
        $.ajax({
            url: '<?= site_url("posts/add_comment"); ?>',
            type: 'POST',
            data: { entry_id: entryId, comment: comment },
            success: function(response) {
                var parsedResponse = JSON.parse(response);

                if (parsedResponse.success) {
                    // Clear the input
                    $('.comment-form input[name="comment"]').val('');
                    // Refresh the comments list
                    refreshComments(entryId);
                    alert(parsedResponse.data);

                } else {
                    alert(parsedResponse.data);
                }
            }
        });
    });

    // Function to refresh comments
    function refreshComments(entryId) {
    $.ajax({
        url: '<?= site_url("posts/get_comments"); ?>',
        type: 'GET',
        data: { entry_id: entryId },
        success: function(response) {
            var parsedResponse = JSON.parse(response);

            if (parsedResponse.success) {
                // Update the comments list in the DOM
                let commentsHtml = '';
                parsedResponse.data.comments.forEach(function(comment) {
                    commentsHtml += '<li class="border-b pb-2">' +
                                    '<strong>' + comment.firstname + ' ' + comment.lastname + ':</strong> ' +
                                    '<p>' + comment.comment + '</p>' +
                                    '</li>';
                });
                $('#commentList-' + entryId).html(commentsHtml);
                // Update comment count
                $('#commentCount-' + entryId).text(parsedResponse.data.comments.length);
            } else {
                alert(parsedResponse.message);
            }
        }
    });
}


    $('#entry-form').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this);

        if (marker) {
            formData.append('latitude', marker.getLatLng().lat);
            formData.append('longitude', marker.getLatLng().lng);
        }

        const fileInput = $('#image-upload')[0];
        if (fileInput.files[0]) {
            formData.append('photo_url', fileInput.files[0]);
        }

        const selectedTags = $('input[name="tags[]"]:checked').map(function () {
            return this.value;
        }).get();
        formData.delete('tags[]');
        selectedTags.forEach(tag => formData.append('tags[]', tag));

        // Log the FormData to check its contents
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Send the AJAX request
        $.ajax({
            url: '<?= site_url("posts/save-entry"); ?>', // Ensure this URL is correct
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Post saved successfully!',
                    text: data.message || 'Your post has been successfully saved.',
                    showConfirmButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.reset();
                        $('#image-preview').html('<span>Image Preview</span>');

                        if (marker) {
                            map.removeLayer(marker);
                            marker = null;
                        }

                        if (!mapContainer.classList.contains('hidden')) {
                            mapContainer.classList.add('hidden');
                            toggleMapButton.textContent = 'Add Location';
                        }

                        modal.querySelector('.modal-container').classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            modal.classList.add('opacity-0', 'pointer-events-none');
                            document.body.classList.remove('modal-active');
                        }, 300);

                        location.reload(); // Refresh the page to reflect changes
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                try {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message || 'An error occurred while processing your request.');
                } catch (e) {
                    alert('An unexpected error occurred. Please try again.');
                }
            }
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    const posts = <?php echo json_encode($posts); ?>; // Pass PHP data to JavaScript

    posts.forEach(post => {
        const mapId = `map-${post.entry_id}`; // Use the unique ID for each post's map container
        const mapElement = document.getElementById(mapId);

        if (mapElement && post.latitude && post.longitude) {
            const map = L.map(mapId).setView([post.latitude, post.longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([post.latitude, post.longitude])
                .addTo(map)
                .bindPopup(post.destination)
                .openPopup();
        }
    });

    // Set initial like button colors
    $('.like-button').each(function() {
        if ($(this).data('liked') === 'true') {
            $(this).addClass('text-blue-600').removeClass('text-gray-600');
        }
    });
});

</script>
