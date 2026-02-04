<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    // 1. Show the list (Everyone)
    public function index() {
        $items = Inventory::orderBy('created_at', 'desc')->get();
        return view('inventory', compact('items'));
    }

    // 2. Add Item (Admin Only)
    public function store(Request $request) {
        if (Auth::user()->role !== 'admin') { abort(403); }

        $request->validate([
            'item_name' => 'required',
            'category'  => 'required', // Enum values: Food, Medical, Equipment, Other
            'quantity'  => 'required|integer|min:1',
            'unit'      => 'required' // e.g., kg, pcs
        ]);

        Inventory::create($request->all());

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }

    // 3. Remove Item (Admin Only)
    public function destroy($id) {
        if (Auth::user()->role !== 'admin') { abort(403); }

        Inventory::destroy($id);
        
        return redirect()->back()->with('success', 'Item removed from inventory.');
    }
}