<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rescue Units & Volunteers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="p-3">Volunteer Name</th>
                            <th class="p-3">Skill</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                            <tr class="border-b">
                                <td class="p-3 font-medium">{{ $unit->name }}</td>
                                <td class="p-3">{{ $unit->skill }}</td>
                                <td class="p-3">{{ $unit->phone }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-sm {{ $unit->status == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $unit->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>