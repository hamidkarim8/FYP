@extends('layouts.master')
@section('title')
    @lang('translation.starter')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Starter
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-body text-justify bg-light py-1 rounded p-4">
            <h1>PIN FOUND ITEM</h1>
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-justify bg-light py-1 rounded p-4">
            <h1>AUTO OBJECT DETECTION</h1>
            <input type="file" id="imageUpload" accept="image/*">
            <button id="uploadButton">Upload Image</button>
            <div id="imageDescription"></div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body text-justify bg-light py-1 rounded p-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Found Items</h5>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10px;">
                                <div class="form-check">
                                    <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reporter</th>
                            <th>Reported Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($foundItems as $foundItem)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </td>
                                <td>{{ $foundItem->id }}</td>
                                <td>{{ $foundItem->itemName }}</td>
                                <td>{{ $foundItem->description }}</td>
                                <td>{{ $foundItem->location }}</td>
                                <td>{{ $foundItem->dateFound }}</td>
                                <td>{{ $foundItem->isResolved ? 'Resolved' : 'Unresolved' }}</td>
                                <td>{{ $foundItem->user->name }}</td>
                                <td>{{ $foundItem->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
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
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="{{ URL::asset('/assets/js/starter.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
