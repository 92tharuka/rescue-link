<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\SafeZone;

class AdminController extends Controller
{
    // 1. Show the Admin Page
    public function index()
    {
        return view('admin');
    }

    // 2. Save a New Volunteer
    public function storeVolunteer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'skill' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        Volunteer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'skill' => $request->skill,
            'status' => 'Available',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->back()->with('success', 'Volunteer Recruited!');
    }

    // 3. Save a New Safe Zone
    public function storeSafeZone(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'capacity' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        SafeZone::create([
            'name' => $request->name,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->back()->with('success', 'Safe Zone Established!');
    }
}