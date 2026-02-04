<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescue-Link | National Disaster Response</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-pattern {
            background-color: #111827;
            background-image: radial-gradient(#374151 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="absolute top-0 w-full z-20 transition-all duration-300 p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-red-600 text-white p-2 rounded-lg">
                    <i class='bx bxs-megaphone text-xl'></i>
                </div>
                <span class="text-white font-bold text-2xl tracking-tight">RESCUE<span class="text-red-500">LINK</span></span>
            </div>
            
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('volunteer.create') }}" class="group flex items-center gap-2 text-white bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition border border-white/20 backdrop-blur-sm">
                    <i class='bx bxs-hard-hat'></i> Join Force
                </a>
                <a href="{{ route('missing.index') }}" class="flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-full font-bold shadow-lg shadow-blue-900/50 transition transform hover:-translate-y-0.5">
                    <i class='bx bx-search-alt'></i> Missing Persons
                </a>
                <div class="flex items-center gap-4">
    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium text-sm">Login</a>

    <a href="{{ route('register') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-4 py-2 rounded-full font-bold text-sm transition">
        Register
    </a>
</div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex items-center justify-center pt-20 pb-12 px-6 hero-pattern">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-900/90 via-gray-900/80 to-gray-900"></div>
        
        <div class="relative z-10 grid lg:grid-cols-2 gap-12 max-w-7xl mx-auto items-center">
            
            <div class="text-center lg:text-left space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-semibold animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Live Emergency System Active
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight">
                    Help is just <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500">one click away.</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-lg mx-auto lg:mx-0">
                    Direct connection to national rescue teams. If you are in danger, do not wait. Signal for help immediately.
                </p>
                
                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-800 mt-8">
                    <div>
                        <div class="text-3xl font-bold text-white">{{ $safeZones->count() }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">Safe Zones</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">24/7</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">Operation</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">GPS</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">Tracking</div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-2xl shadow-2xl transform transition hover:scale-[1.01]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class='bx bxs-error-circle text-red-600 text-3xl'></i> 
                        Request Rescue
                    </h2>
                    <span class="text-xs font-bold bg-red-100 text-red-600 px-2 py-1 rounded">PRIORITY HIGH</span>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r">
                        <div class="flex items-center gap-2">
                            <i class='bx bxs-check-circle text-green-600 text-xl'></i>
                            <p class="text-green-700 font-bold">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('request.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase">Your Name</label>
                            <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition" placeholder="John Doe" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase">Phone</label>
                            <input type="text" name="phone" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition" placeholder="07x-xxxxxxx" required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Emergency Type</label>
                        <div class="relative">
                            <i class='bx bxs-ambulance absolute left-3 top-3.5 text-gray-400'></i>
                            <select name="type" class="w-full pl-10 bg-gray-50 border border-gray-200 p-3 rounded-lg focus:ring-2 focus:ring-red-500 outline-none appearance-none font-semibold">
                                <option value="Medical">🚑 Medical Emergency</option>
                                <option value="Flood">🌊 Trapped by Flood</option>
                                <option value="Food/Water">🍎 Need Supplies</option>
                                <option value="Other">⚠️ Critical / Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Situation Details</label>
                        <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg focus:ring-2 focus:ring-red-500 outline-none" placeholder="Describe your surroundings..."></textarea>
                    </div>

                    <input type="hidden" name="latitude" value="6.9271">
                    <input type="hidden" name="longitude" value="79.8612">

                    <button class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-500/30 transition transform active:scale-95 flex items-center justify-center gap-2 text-lg">
                        <i class='bx bxs-send'></i> SEND SOS SIGNAL
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-2">
                        <i class='bx bxs-lock-alt'></i> Your location is encrypted and sent to HQ.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Active Safe Zones</h2>
                    <p class="text-gray-500">Go to these locations for shelter and food.</p>
                </div>
                <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Live Map
                </span>
            </div>
            
            <div id="publicMap" class="h-[500px] w-full rounded-2xl shadow-inner border border-gray-200 z-0"></div>
        </div>
    </div>

    <footer class="bg-gray-900 text-gray-400 py-12 text-center border-t border-gray-800">
        <p>&copy; 2026 Rescue-Link National System. University Project.</p>
    </footer>

    <script>
        // Initialize Map with a Dark/Professional Theme
        var map = L.map('publicMap').setView([6.9271, 79.8612], 12);
        
        // Use a clean map tile style
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var safeZones = @json($safeZones ?? []);
        
        safeZones.forEach(function(zone) {
            var greenIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker([zone.latitude, zone.longitude], {icon: greenIcon})
                .addTo(map)
                .bindPopup(
                    `<div class='text-center p-2'>
                        <b class='text-green-600 text-lg'>🛡️ ${zone.name}</b><br>
                        <span class='text-gray-600'>${zone.type}</span><br>
                        <span class='font-bold'>Capacity: ${zone.capacity}</span>
                    </div>`
                );
        });
    </script>
    <script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.querySelector('input[name="latitude"]').value = position.coords.latitude;
            document.querySelector('input[name="longitude"]').value = position.coords.longitude;
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
</script>
</body>
</html>