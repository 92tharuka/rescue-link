<?php

namespace App\Http\Controllers;

use App\Models\SafeZone;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\RescueRequest;

class RescueController extends Controller
{
    // 1. Show the form to victims (Home Page)
    public function create() {
        $safeZones = SafeZone::all(); 
        return view('welcome', compact('safeZones'));
    }

// 1. Delete a Volunteer/Unit
public function deleteVolunteer($id) {
    \App\Models\Volunteer::destroy($id);
    return redirect()->back()->with('success', 'Unit removed from system.');
}

// 2. Delete a Safe Zone
public function deleteSafeZone($id) {
    $zone = \App\Models\SafeZone::findOrFail($id);
    $zone->delete();
    return redirect()->back()->with('success', 'Safe Zone removed.');
}

// 3. Update an Emergency Request (Edit)
public function updateRequest(Request $request, $id) {
    $req = \App\Models\RescueRequest::findOrFail($id);
    $req->update($request->only(['type', 'priority', 'description']));
    return redirect()->back()->with('success', 'Emergency details updated.');
}



    public function userDashboard() 
{
    // Fetch data specifically for user consumption
    $requests = RescueRequest::where('status', 'Pending')->latest()->get();
    $volunteers = Volunteer::all();
    $safeZones = SafeZone::all();

    return view('user_dashboard', compact('requests', 'volunteers', 'safeZones'));
}

    

    // 2. Save the Rescue Request (SOS)
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'type' => 'required|in:Flood,Fire,Medical,Trapped,Other',
        ]);

        RescueRequest::create($request->all());

        return redirect()->back()->with('success', 'Help request received! Stay put.');
    }

    // 3. Show the Dashboard to Admin
    public function index() {
        $requests = RescueRequest::where('status', 'Pending')
                ->orderBy('priority', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        $volunteers = Volunteer::where('status', 'Available')->get();
        $safeZones = SafeZone::all();

        return view('dashboard', compact('requests', 'volunteers', 'safeZones'));
    }
    
    // 4. Mark Request as Resolved
    public function resolve($id) {
        $req = RescueRequest::find($id);
        $req->status = 'Resolved';
        $req->save();
        return redirect()->back();
    }

    // 5. Show the Public Volunteer Registration Page
    public function volunteerCreate() {
        return view('volunteer_register');
    }

    // 6. Save the New Volunteer
    public function volunteerStore(Request $request) {
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

        return redirect()->route('home')->with('success', 'Welcome to the team!');
    }

    // --- ADDED METHODS TO FIX THE ERROR ---

    /**
     * 7. Show all Emergency Requests (Mapped to 'emergencies.all')
     */
    public function allEmergencies() {
        $emergencies = RescueRequest::orderBy('created_at', 'desc')->get();
        return view('emergencies', compact('emergencies'));
    }

    /**
     * 8. Show all Rescue Units/Volunteers (Mapped to 'units.all')
     */
    public function allUnits() {
        $units = Volunteer::all();
        return view('units', compact('units'));
    }

    /**
     * 9. Show all Safe Zones (Mapped to 'safezones.all')
     */
    public function allSafeZones() {
        $safeZones = SafeZone::all();
        return view('safe_zones', compact('safeZones'));
    }

    
}