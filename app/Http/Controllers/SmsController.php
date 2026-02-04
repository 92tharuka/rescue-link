<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RescueRequest;

class SmsController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Get data from the "SMS" (Twilio sends 'Body' and 'From')
        $incomingText = $request->input('Body'); // e.g., "MEDICAL Broken leg"
        $phoneNumber = $request->input('From');  // e.g., "+94771234567"

        // 2. Simple Parsing Logic
        // We assume the FIRST word is the NEED (Food, Water, Medical)
        $words = explode(' ', trim($incomingText), 2);

        $parts = explode(' ', trim($incomingText), 2);
        $type = strtoupper($parts[0] ?? 'OTHER'); // Default to OTHER
        $description = $parts[1] ?? 'SMS Request';
        
        $type = strtoupper($words[0] ?? 'OTHER'); // Default to OTHER if empty
        $description = $words[1] ?? 'No description provided';

        // Map SMS keywords to your Database Enum types
        $validTypes = ['FOOD', 'WATER', 'MEDICAL', 'EVACUATION'];
        if (!in_array($type, $validTypes)) {
            $type = 'Other';
            $description = $incomingText; // If keyword is missing, save whole text as desc
        } else {
            // Fix capitalization (e.g., "FOOD" -> "Food")
            $type = ucfirst(strtolower($type));
        }

        // 3. Save to Database
        RescueRequest::create([
            'name'        => 'SMS User',    // We don't know their name
            'phone'       => $phoneNumber,
            'type'        => ucfirst(strtolower($type)),
            'description' => $description . " [Source: SMS]",
            'latitude'    => 6.9271,        // Default Placeholder (Colombo)
            'longitude'   => 79.8612,       // Default Placeholder
            'status'      => 'Pending'
        ]);

        return response('SMS Received', 200);
    }
}
