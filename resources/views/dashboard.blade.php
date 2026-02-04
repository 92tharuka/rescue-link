<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        html { scroll-behavior: smooth; }
        body { background-color: #f1f5f9 !important; color: #1e293b; font-family: 'Inter', system-ui, sans-serif; }
        
        /* Offset for scrolling to sections */
        #reports-section, #units-section, #map-section { scroll-margin-top: 100px; }
        
        .btn-ops {
            background-color: #4f46e5 !important; color: white !important; display: inline-flex !important;
            align-items: center; padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 0.875rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3); border: 1px solid #4338ca; z-index: 1000;
            text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.2s;
        }
        .btn-ops:hover { background-color: #4338ca !important; transform: translateY(-1px); }
        .glass-card { background-color: #ffffff; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); }
        .map-wrapper { height: 500px !important; width: 100%; position: relative; background-color: #e2e8f0; z-index: 1; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
    </style>

    <div class="min-h-screen pb-12">
        <div class="bg-white border-b border-slate-200 sticky top-0 z-[200] shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div class="bg-slate-800 text-white flex items-center justify-center w-9 h-9 rounded-lg shadow-md">
                            <i class='bx bxs-dashboard text-xl'></i>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="font-bold text-lg text-slate-800 leading-none">Command Center</h1>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Enterprise Edition v2.4</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="{{ route('inventory') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors flex items-center gap-2">
                            <i class='bx bxs-box text-slate-400'></i> Inventory
                        </a>
                        <a href="{{ route('missing.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors flex items-center gap-2">
                            <i class='bx bxs-user-pin text-slate-400'></i> Missing
                        </a>
                        <div class="h-6 w-px bg-slate-200"></div>
                        <a href="{{ route('admin.operations') }}" class="btn-ops">
                            <i class='bx bxs-cog mr-2'></i> Operations
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="#reports-section" class="glass-card p-5 rounded-xl flex items-center justify-between relative overflow-hidden group hover:border-red-400 transition-colors cursor-pointer">
                    <div class="absolute right-0 top-0 h-full w-1 bg-red-500"></div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Threats</p>
                        <h2 class="text-3xl font-bold text-slate-900 mt-1">{{ $requests->count() }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 border border-red-100 group-hover:bg-red-500 group-hover:text-white transition-all">
                        <i class='bx bxs-bell-ring text-xl'></i>
                    </div>
                </a>

                <a href="#units-section" class="glass-card p-5 rounded-xl flex items-center justify-between relative overflow-hidden group hover:border-emerald-400 transition-colors cursor-pointer">
                    <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Field Units</p>
                        <h2 class="text-3xl font-bold text-slate-900 mt-1">{{ $volunteers->count() }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class='bx bxs-ambulance text-xl'></i>
                    </div>
                </a>

                <a href="#map-section" class="glass-card p-5 rounded-xl flex items-center justify-between relative overflow-hidden group hover:border-blue-400 transition-colors cursor-pointer">
                    <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Safe Zones</p>
                        <h2 class="text-3xl font-bold text-slate-900 mt-1">{{ $safeZones->count() }}</h2>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <i class='bx bxs-building-house text-xl'></i>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div id="map-section" class="lg:col-span-2 glass-card rounded-xl overflow-hidden flex flex-col">
                    <div class="px-5 py-3 bg-white border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <i class='bx bxs-map text-indigo-500'></i> Tactical Overview
                        </h3>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> LIVE
                        </span>
                    </div>
                    <div class="map-wrapper">
                        <div id="map" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>

                <div class="glass-card rounded-xl overflow-hidden flex flex-col h-[552px]">
                    <div class="px-5 py-3 bg-white border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <i class='bx bxs-data text-indigo-500'></i> Incoming Reports
                        </h3>
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scroll p-4 bg-white">
                        
                        <div id="reports-section" class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Distress Signals</h4>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full border border-slate-200">{{ $requests->count() }}</span>
                            </div>

                            @if($requests->isEmpty())
                                <div class="text-center py-8 border-2 border-dashed border-slate-100 rounded-lg">
                                    <p class="text-xs text-slate-400">System Clear</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($requests as $req)
                                        <div class="bg-white border-l-4 rounded-lg p-3 hover:shadow-md transition-all group {{ $req->priority == 1 ? 'border-red-600 bg-red-50/30' : 'border-slate-200' }}">
                                            <div class="flex justify-between items-start mb-2">
                                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $req->type }}</span>
                                                @if($req->priority == 1)
                                                    <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75 right-8"></span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-500 mb-3 line-clamp-2">{{ $req->description }}</p>
                                            <div class="flex justify-between items-center pt-2 border-t border-slate-50">
                                                <div class="flex items-center gap-1 text-xs text-slate-400 font-mono">
                                                    <i class='bx bxs-phone'></i> {{ $req->phone }}
                                                </div>
                                                <div class="flex gap-2">
                                                    <button onclick="focusOnMap({{ $req->latitude }}, {{ $req->longitude }}, '{{ $req->type }}')" class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded uppercase">Locate</button>
                                                    <form action="{{ route('request.resolve', $req->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-[10px] font-bold text-black bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded uppercase">Resolve</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div id="units-section" class="pt-4 border-t border-slate-100">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Field Units</h4>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full border border-slate-200">{{ $volunteers->count() }}</span>
                            </div>

                            <div class="space-y-2">
                                @foreach($volunteers as $vol)
                                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                                {{ substr($vol->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-bold text-slate-700">{{ $vol->name }}</div>
                                                <div class="text-[10px] text-slate-400 uppercase">{{ $vol->skill }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <form action="{{ route('admin.volunteer.delete', $vol->id) }}" method="POST" onsubmit="return confirm('Remove unit?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600"><i class='bx bx-trash'></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="safezones-section" class="pt-4 border-t border-slate-100">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Managed Safe Zones</h4>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full border border-slate-200">{{ $safeZones->count() }}</span>
                            </div>

                            <div class="space-y-2">
                                @foreach($safeZones as $zone)
                                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-blue-50 flex items-center justify-center text-xl text-blue-500 border border-blue-100">
                                                <i class='bx bxs-building-house'></i>
                                            </div>
                                            <div>
                                                <div class="text-xs font-bold text-slate-700">{{ $zone->name }}</div>
                                                <div class="text-[10px] text-slate-400 uppercase">Cap: {{ $zone->capacity ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <form action="{{ route('admin.safezone.delete', $zone->id) }}" method="POST" onsubmit="return confirm('Remove this Safe Zone?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600"><i class='bx bx-trash'></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var mainMap;
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                mainMap = L.map('map', { zoomControl: false }).setView([6.9271, 79.8612], 13);
                L.control.zoom({ position: 'bottomright' }).addTo(mainMap);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(mainMap);

                var criticalIcon = new L.Icon({ iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png', iconSize: [25, 41], iconAnchor: [12, 41] });
                var safeIcon = new L.Icon({ iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png', iconSize: [25, 41], iconAnchor: [12, 41] });

                var requests = @json($requests);
                var safeZones = @json($safeZones);

                requests.forEach(req => {
                    if(req.latitude && req.longitude) {
                        L.marker([req.latitude, req.longitude], {icon: criticalIcon}).addTo(mainMap).bindPopup(`<b>SOS: ${req.type}</b>`);
                    }
                });

                safeZones.forEach(zone => {
                    if(zone.latitude && zone.longitude) {
                        L.marker([zone.latitude, zone.longitude], {icon: safeIcon}).addTo(mainMap).bindPopup(`<b>Safe Zone: ${zone.name}</b>`);
                    }
                });
                mainMap.invalidateSize();
            }, 500);
        });

        function focusOnMap(lat, lng, type) {
            if (mainMap) { mainMap.setView([lat, lng], 17, { animate: true, duration: 1.5 }); }
        }
    </script>
</x-app-layout>