<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ⚙️ Operations Manager
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 shadow-lg rounded-lg">
                    <h3 class="font-bold text-lg mb-4 text-indigo-600">⛑️ Recruit Volunteer</h3>
                    <p class="text-sm text-gray-500">Use this form to manually register a unit.</p>
                    </div>

                <div class="bg-white p-6 shadow-lg rounded-lg">
                    <h3 class="font-bold text-lg mb-4 text-green-600">🛡️ Establish Safe Zone</h3>
                    
                    <form action="{{ route('admin.safezone.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Location Name</label>
                            <input type="text" name="name" placeholder="e.g. Central College" class="w-full border p-2 rounded focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                            <select name="type" class="w-full border p-2 rounded">
                                <option>School</option>
                                <option>Temple / Church</option>
                                <option>Hospital</option>
                                <option>Community Center</option>
                                <option>High Ground</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Capacity (People)</label>
                            <input type="number" name="capacity" placeholder="500" class="w-full border p-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Location (Click on Map)</label>
                            
                            <div id="zoneMap" style="height: 250px; width: 100%; border-radius: 0.5rem; z-index: 0;"></div>
                            
                            <input type="hidden" name="latitude" id="latitude" required>
                            <input type="hidden" name="longitude" id="longitude" required>
                            
                            <p class="text-xs text-gray-500 mt-2">
                                Selected Coordinates: <span id="coords-display" class="font-mono text-green-600 font-bold">None</span>
                            </p>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-500 transition-colors shadow-md">
                            Create Safe Zone
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Map (Default view: Colombo)
            var map = L.map('zoneMap').setView([6.9271, 79.8612], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker;

            // Handle Map Click
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // 1. Move or Create Marker
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                // 2. Update Hidden Inputs
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // 3. Update Visual Text
                document.getElementById('coords-display').innerText = lat.toFixed(5) + ", " + lng.toFixed(5);
            });
        });
    </script>
</x-app-layout>