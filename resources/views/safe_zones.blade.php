<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Safe Zones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($safeZones as $zone)
                        <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                            <h3 class="text-lg font-bold text-blue-600">{{ $zone->name }}</h3>
                            <p class="text-gray-600 mt-2"><strong>Location:</strong> {{ $zone->latitude }}, {{ $zone->longitude }}</p>
                            <div class="mt-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Active Zone</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
