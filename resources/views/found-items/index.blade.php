<!-- resources/views/found-items/index.blade.php -->

<h1>Found Items</h1>


@if($foundItems)
<ul>
    @foreach($foundItems as $foundItem)
        <li>{{ $foundItem->name }}</li>
    @endforeach
</ul>@else
    <p>No items found.</p>
@endif

// Initialize the map
var map = L.map('map').setView([3.05603, 101.70022], 17);

// Add a tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Function to add markers
function addMarker(lat, lng, description) {
    var marker = L.marker([lat, lng]).addTo(map);
    if (description) {
        marker.bindPopup(description); // Show description on marker click
    }
}

// Example markers
addMarker(51.5, -0.09, "Description 1");
addMarker(51.51, -0.1, "Description 2");
// Add more markers as needed

// You can also allow users to add markers by clicking on the map and capturing the click event
map.on('click', function(e) {
    var description = prompt("Enter description for this location:");
    addMarker(e.latlng.lat, e.latlng.lng, description);
});

// Function to handle image upload and description retrieval
document.getElementById('uploadButton').addEventListener('click', function() {
    var fileInput = document.getElementById('imageUpload');
    var file = fileInput.files[0]; // Get the file
    var formData = new FormData();
    formData.append('providers', 'amazon, api4ai');
    formData.append('file', file);
    formData.append('fallback_providers', '');

    axios.post('https://api.edenai.run/v2/image/object_detection', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiYTk5YzVhOTctYmY2My00YmRkLWIxYTMtMzZlYzk5NmQ1ZjQwIiwidHlwZSI6ImFwaV90b2tlbiJ9.ZEHn-AZeHgReKaBg2UN452S1B8pBiwqrCPy6C5b_KEg'
            }
        })
        .then(function(response) {
            console.log(response.data);
            // Display image description on the webpage
            var label = response.data['eden-ai'].items[0].label;
            document.getElementById('imageDescription').innerHTML = "<p>" + label + "</p>";
        })
        .catch(function(error) {
            console.error(error);
        });
});