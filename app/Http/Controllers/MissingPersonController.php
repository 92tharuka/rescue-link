<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissingPerson;
use Illuminate\Support\Facades\Storage;

class MissingPersonController extends Controller
{
    /**
     * 1. Show the Registry (Command Center / Public View)
     * Includes Search and Triage sorting
     */
    public function index(Request $request)
    {
        $query = MissingPerson::query();

        // Search by name if provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Triage Logic: Show 'Missing' people first, then 'Found' ones.
        // Within those groups, show the most recent reports first.
        $missingPersons = $query->orderBy('status', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();

        // Map to the view name used in your routes (missing_persons)
        return view('missing_persons', compact('missingPersons'));
    }

    /**
     * 2. Store a New Report (with Image handling)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB limit
            'contact_phone' => 'required|string|max:20',
            'last_seen' => 'nullable|string|max:500' // Useful for disaster tracking
        ]);

        // Handle File Upload to public storage
        $imagePath = null;
        if ($request->hasFile('photo')) {
            // Save to 'public/missing_persons' folder
            $imagePath = $request->file('photo')->store('missing_persons', 'public');
        }

        MissingPerson::create([
            'name' => $request->name,
            'description' => $request->description,
            'last_seen' => $request->last_seen, // Matches disaster-centric reporting
            'contact_phone' => $request->contact_phone,
            'photo_path' => $imagePath,
            'status' => 'Missing'
        ]);

        return redirect()->back()->with('success', 'Report successfully posted to the Command Center.');
    }

    /**
     * 3. Mark as Found (Toggle Status)
     * Used by authorities to update family status in real-time
     */
    public function toggleStatus($id)
    {
        $person = MissingPerson::findOrFail($id);
        
        // Toggle logic
        $person->status = ($person->status === 'Missing') ? 'Found' : 'Missing';
        
        $person->save();

        return redirect()->back()->with('success', 'Status for ' . $person->name . ' has been updated.');
    }
}