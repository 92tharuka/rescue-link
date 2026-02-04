<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join the Rescue Team</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-2xl w-full max-w-md border border-green-500">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-green-500 mb-2">⛑️ Join the Force</h1>
            <p class="text-gray-400">Register to help in emergency operations.</p>
        </div>

        <form action="{{ route('volunteer.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-green-400 text-sm font-bold mb-2">Full Name</label>
                <input type="text" name="name" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-green-500 text-white" required>
            </div>

            <div class="mb-4">
                <label class="block text-green-400 text-sm font-bold mb-2">Phone Number</label>
                <input type="text" name="phone" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-green-500 text-white" required>
            </div>

            <div class="mb-6">
                <label class="block text-green-400 text-sm font-bold mb-2">Your Skill</label>
                <select name="skill" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-green-500 text-white">
                    <option>General Helper</option>
                    <option>Doctor / Medic</option>
                    <option>Boat Owner</option>
                    <option>Driver (4x4)</option>
                    <option>Swimmer</option>
                </select>
            </div>

            <input type="hidden" name="latitude" id="lat">
            <input type="hidden" name="longitude" id="lng">
            
            <p id="locStatus" class="text-xs text-yellow-400 mb-4 text-center animate-pulse">
                📡 Detecting your location...
            </p>

            <button type="submit" id="submitBtn" disabled class="w-full bg-green-600 text-white font-bold py-3 rounded opacity-50 cursor-not-allowed">
                Register as Volunteer
            </button>
            
            <div class="mt-4 text-center">
                <a href="/" class="text-gray-400 hover:text-white text-sm">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        // Auto-Detect Location Script
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lng').value = position.coords.longitude;
                    
                    // Enable the button once location is found
                    document.getElementById('locStatus').innerText = "✅ Location Locked: Ready to Register";
                    document.getElementById('locStatus').classList.remove('text-yellow-400', 'animate-pulse');
                    document.getElementById('locStatus').classList.add('text-green-400');
                    
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('submitBtn').classList.remove('opacity-50', 'cursor-not-allowed');
                    document.getElementById('submitBtn').classList.add('hover:bg-green-500');
                },
                function(error) {
                    document.getElementById('locStatus').innerText = "❌ Location Failed. Please allow GPS access.";
                    document.getElementById('locStatus').classList.add('text-red-500');
                }
            );
        }
    </script>

</body>
</html>