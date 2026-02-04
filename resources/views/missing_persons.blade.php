<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Missing Persons | Rescue-Link</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fadeIn { animation: fadeIn 0.2s ease-out forwards; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class='bx bxs-user-pin text-3xl text-blue-600'></i>
                <div>
                    <h1 class="text-xl font-bold leading-none text-gray-900">Missing Persons</h1>
                    <p class="text-xs text-gray-500 font-medium">Public Information Wall</p>
                </div>
            </div>
            <a href="/" class="text-sm font-semibold text-gray-500 hover:text-blue-600 flex items-center gap-1 transition">
                <i class='bx bx-arrow-back'></i> Back Home
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
            <form action="{{ route('missing.index') }}" method="GET" class="w-full md:w-1/2 relative group">
                <i class='bx bx-search absolute left-4 top-3.5 text-gray-400 text-xl group-focus-within:text-blue-500 transition'></i>
                <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}"
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </form>

            <button onclick="document.getElementById('reportModal').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-bold shadow-lg shadow-blue-500/30 flex items-center gap-2 transition transform hover:-translate-y-0.5">
                <i class='bx bx-plus-circle text-xl'></i> Report Missing
            </button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($missingPersons as $person) {{-- Fix: Using $missingPersons instead of $people --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition duration-300 transform hover:-translate-y-1 relative">
                
                @if($person->status == 'Found')
                    <div class="absolute inset-0 bg-white/60 z-10 flex items-center justify-center backdrop-blur-sm">
                        <span class="bg-green-600 text-white px-4 py-2 rounded-full font-bold shadow-lg transform -rotate-12 border-2 border-white">
                            ✅ FOUND SAFE
                        </span>
                    </div>
                @endif

                <div class="h-56 bg-gray-100 overflow-hidden relative">
                    @if($person->photo_path)
                        <img src="{{ asset('storage/' . $person->photo_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                            <i class='bx bx-image-alt text-4xl'></i>
                            <span class="text-xs">No Photo Available</span>
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-900 mb-1 truncate">{{ $person->name }}</h3>
                    <p class="text-xs text-gray-400 mb-2 uppercase font-bold tracking-tighter">Last Seen: {{ $person->last_seen ?? 'Unknown' }}</p>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3 h-10">{{ $person->description }}</p>
                    
                    <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-2 rounded-lg mb-4">
                        <i class='bx bxs-phone'></i> Contact: {{ $person->contact_phone }}
                    </div>

                    @auth
                        <form action="{{ route('missing.toggle', $person->id) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100 relative z-20">
                            @csrf
                            <button class="w-full py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-2
                                {{ $person->status == 'Missing' ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                @if($person->status == 'Missing')
                                    <i class='bx bx-check-circle text-lg'></i> Mark Found
                                @else
                                    <i class='bx bx-undo text-lg'></i> Reopen Case
                                @endif
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                    <i class='bx bx-user-x text-6xl text-gray-200 mb-4'></i>
                    <p class="text-gray-400 font-medium">No records found matching your criteria.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div id="reportModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white p-8 rounded-2xl w-full max-w-lg shadow-2xl relative animate-fadeIn">
            <button onclick="document.getElementById('reportModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class='bx bx-x text-2xl'></i>
            </button>
            
            <h2 class="text-2xl font-bold mb-1 text-gray-900">Report Missing Person</h2>
            <p class="text-gray-500 text-sm mb-6">Please provide accurate details to help the search.</p>
            
            <form action="{{ route('missing.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Reporter Phone</label>
                        <input type="text" name="contact_phone" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Clear Photo</label>
                        <input type="file" name="photo" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Last Seen Location</label>
                    <input type="text" name="last_seen" placeholder="e.g. Near the city library" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Description</label>
                    <textarea name="description" rows="3" placeholder="Height, clothing, distinguishing marks..." class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Submit Public Report
                </button>
            </form>
        </div>
    </div>

</body>
</html>