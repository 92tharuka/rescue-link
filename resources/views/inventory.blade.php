<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class='bx bxs-box text-indigo-600'></i> {{ __('Relief Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-r">
                    <p class="font-bold flex items-center gap-2"><i class='bx bxs-check-circle'></i> Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(Auth::user()->role === 'admin')
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-8 border-t-4 border-indigo-600">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 uppercase tracking-wide flex items-center gap-2">
                        <i class='bx bxs-layer-plus'></i> Add New Supplies
                    </h3>
                    <form action="{{ route('inventory.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Item Name</label>
                            <input type="text" name="item_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Rice Packets" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Category</label>
                            <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Food">Food</option>
                                <option value="Medical">Medical</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-2/3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Qty</label>
                                <input type="number" name="quantity" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0" required>
                            </div>
                            <div class="w-1/3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Unit</label>
                                <input type="text" name="unit" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="kg/pcs" required>
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-md transition-colors shadow-md flex items-center justify-center gap-2">
                            <i class='bx bx-plus'></i> ADD
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                            <i class='bx bxs-data'></i> Current Stockpile
                        </h3>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                            {{ $items->count() }} Items Recorded
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase border-b border-gray-200">
                                    <th class="py-3 pl-2">Item Name</th>
                                    <th class="py-3">Category</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-right pr-4">Quantity</th>
                                    @if(Auth::user()->role === 'admin') <th class="py-3 text-right">Admin</th> @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors group">
                                    <td class="py-4 pl-2">
                                        <span class="font-bold text-gray-700 block">{{ $item->item_name }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide
                                            {{ $item->category == 'Food' ? 'bg-orange-100 text-orange-600' : '' }}
                                            {{ $item->category == 'Medical' ? 'bg-red-100 text-red-600' : '' }}
                                            {{ $item->category == 'Equipment' ? 'bg-blue-100 text-blue-600' : '' }}
                                            {{ $item->category == 'Other' ? 'bg-gray-100 text-gray-600' : '' }}
                                        ">
                                            {{ $item->category }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        @if($item->quantity > 50)
                                            <span class="text-xs font-bold text-green-600 flex items-center gap-1"><i class='bx bxs-circle text-[8px]'></i> Good</span>
                                        @elseif($item->quantity > 0)
                                            <span class="text-xs font-bold text-orange-500 flex items-center gap-1"><i class='bx bxs-circle text-[8px]'></i> Low</span>
                                        @else
                                            <span class="text-xs font-bold text-red-500 flex items-center gap-1"><i class='bx bxs-circle text-[8px]'></i> Empty</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right pr-4">
                                        <span class="font-mono font-bold text-lg text-gray-800">{{ $item->quantity }}</span>
                                        <span class="text-xs text-gray-400 uppercase ml-1">{{ $item->unit }}</span>
                                    </td>
                                    
                                    @if(Auth::user()->role === 'admin')
                                    <td class="py-4 text-right">
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Permanently remove {{ $item->item_name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition-all" title="Remove Item">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-package text-4xl mb-2'></i>
                                            <p>No supplies found in inventory.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>