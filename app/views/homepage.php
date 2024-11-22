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
                    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center transition-opacity duration-300 ease-in-out">
                        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
                        
                        <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded-lg shadow-2xl z-50 overflow-y-auto p-6">
                            <div class="modal-content">
                                <!-- Header Section -->
                                <div class="flex justify-between items-center pb-4 border-b border-gray-300">
                                    <p class="text-2xl font-semibold text-gray-800">Create Post</p>
                                    <div class="modal-close cursor-pointer text-gray-600 hover:text-gray-800 transition duration-300">
                                        <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <form id="entry_form">
                                    <!-- Post Content Section -->
                                    <div class="space-y-6">
                                        <textarea name="description" class="w-full p-4 border border-gray-300 rounded-lg resize-none bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" placeholder="What's on your mind?"></textarea>
                                        
                                        <!-- Image Upload Section -->
                                        <div class="space-y-4">
                                            <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                                            <div class="flex flex-col items-start space-y-4">
                                                <label for="image-upload" class="cursor-pointer bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                                                    Choose Image
                                                </label>
                                            </div>

                                            <div id="image-preview" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                                <span>Image Preview</span>
                                            </div>

                                            <div id="map-container" class="hidden space-y-4">
                                                <div id="map" class="w-full h-64 bg-gray-200 rounded-lg"></div>
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">Enter Location</label>
                                                    <div class="flex gap-2">
                                                        <input id="location-input" name="destination" placeholder="Search for a location" class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                                        <button id="location-btn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                                            Share Location
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="file" id="image-upload" class="hidden" accept="image/*">
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex justify-between">
                                            <button id="toggle-map" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">
                                                Add Location
                                            </button>
                                            <button class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                                Post
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Post -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                            <div>
                                <h3 class="font-bold">Jane Doe</h3>
                                <p class="text-sm text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <p class="mb-4">Just arrived in Bali! The beaches here are absolutely stunning. Can't wait to explore more! 🌴🏖️ #BaliAdventure</p>
                        <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600" id="likeButton">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="likeCount">0</span> Likes
                            </button>
                            <button class="text-gray-600 hover:text-blue-600" id="showComments">
                                <span id="commentCount">0</span> Comments
                            </button>
                        </div>
                        <div id="commentSection" class="hidden mt-4">
                            <div class="border-t pt-4 mb-4">
                                <h4 class="font-bold mb-2">Comments</h4>
                                <ul id="commentList" class="space-y-2"></ul>
                            </div>
                            <form id="commentForm" class="flex gap-2">
                                <input type="text" id="commentInput" placeholder="Add a comment..." class="flex-grow p-2 border rounded-lg">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Leaflet.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Modal functionality
        var openmodal = document.getElementById('post-creator-trigger')
        var modal = document.querySelector('.modal')
        var closemodal = document.querySelector('.modal-close')
        var overlay = document.querySelector('.modal-overlay')

        openmodal.addEventListener('click', function() {
            modal.classList.remove('opacity-0')
            modal.classList.remove('pointer-events-none')
            document.body.classList.add('modal-active')
        })

        closemodal.addEventListener('click', closeModal)
        overlay.addEventListener('click', closeModal)

        function closeModal() {
            modal.classList.add('opacity-0')
            modal.classList.add('pointer-events-none')
            document.body.classList.remove('modal-active')
        }

        // Map functionality
        var map = null
        var marker = null
        var savedLatitude = null
        var savedLongitude = null
        var savedLocationName = null

        document.getElementById('toggle-map').addEventListener('click', function() {
            var mapContainer = document.getElementById('map-container')
            if (mapContainer.classList.contains('hidden')) {
                mapContainer.classList.remove('hidden')
                this.textContent = 'Hide Map'
                initializeMap()
            } else {
                mapContainer.classList.add('hidden')
                this.textContent = 'Add Location'
            }
        })

        function initializeMap() {
            if (!map) {
                map = L.map('map').setView([0, 0], 2)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map)

                document.getElementById('location-btn').addEventListener('click', pinLocation)
                document.getElementById('location-input').addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault()
                        pinLocation()
                    }
                })
            }
        }

        function pinLocation() {
            var locationInput = document.getElementById('location-input').value

            if (locationInput.trim()) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(locationInput)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            savedLatitude = parseFloat(data[0].lat)
                            savedLongitude = parseFloat(data[0].lon)
                            savedLocationName = data[0].display_name
                            var latLng = [savedLatitude, savedLongitude]

                            if (marker) {
                                map.removeLayer(marker)
                            }

                            marker = L.marker(latLng).addTo(map)
                            map.setView(latLng, 13)
                            marker.bindPopup(savedLocationName).openPopup()

                            console.log('Saved Location:', savedLocationName)
                            console.log('Latitude:', savedLatitude)
                            console.log('Longitude:', savedLongitude)
                        } else {
                            alert('Location not found. Please try a different search term.')
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error)
                        alert('An error occurred while searching for the location. Please try again.')
                    })
            } else {
                alert('Please enter a location.')
            }
        }

        // Image preview functionality
        document.getElementById('image-upload').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('image-preview')
            const file = event.target.files[0]
            if (file) {
                const reader = new FileReader()
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`
                }
                reader.readAsDataURL(file)
            }
        })
    </script>

    <script>
        
    </script>
