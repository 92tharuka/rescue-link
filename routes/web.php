<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RescueController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MissingPersonController;

// ==========================================
// 1. PUBLIC ROUTES (No Login Required)
// ==========================================

// Home Page (Victim Request Form)
Route::get('/', [RescueController::class, 'create'])->name('home');
Route::post('/request', [RescueController::class, 'store'])->name('request.store');

// SMS Webhook
Route::post('/sms/receive', [SmsController::class, 'receive']);

// Volunteer Registration
Route::get('/join', [RescueController::class, 'volunteerCreate'])->name('volunteer.create');
Route::post('/join', [RescueController::class, 'volunteerStore'])->name('volunteer.store');

// Missing Persons (Public View & Report)
Route::get('/missing', [MissingPersonController::class, 'index'])->name('missing.index');
Route::post('/missing', [MissingPersonController::class, 'store'])->name('missing.store');


// ==========================================
// 2. PROTECTED ROUTES (Must be Logged In)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // --- SHARED VIEW ROUTES (Accessible by User & Admin) ---
    
    // User Dashboard (Read-Only View)
    Route::get('/dashboard', [RescueController::class, 'userDashboard'])->name('dashboard');
    
    // Inventory List (Read-Only for Users)
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory'); 

    // User Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- ADMIN COMMAND CENTER (Admin Access Only) ---
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        
        // 1. Main Dashboard
        Route::get('/dashboard', [RescueController::class, 'index'])->name('admin.dashboard');
        
        // 2. Operations Page (Add Zones, Recruit Units)
        Route::get('/operations', [AdminController::class, 'index'])->name('admin.operations');
        
        // 3. Tactical Views (Optional pages)
        Route::get('/emergencies', [RescueController::class, 'allEmergencies'])->name('emergencies.all');
        Route::get('/units', [RescueController::class, 'allUnits'])->name('units.all');
        Route::get('/safe-zones', [RescueController::class, 'allSafeZones'])->name('safezones.all');

        // --- ADMIN ACTIONS (Write/Delete) ---

        // A. Manage Requests
        Route::post('/resolve/{id}', [RescueController::class, 'resolve'])->name('request.resolve');
        Route::patch('/request/{id}', [RescueController::class, 'updateRequest'])->name('admin.request.update');

        // B. Manage Safe Zones
        Route::post('/safezone', [AdminController::class, 'storeSafeZone'])->name('admin.safezone.store');
        Route::delete('/safezone/{id}', [RescueController::class, 'deleteSafeZone'])->name('admin.safezone.delete');

        // C. Manage Volunteers/Units
        Route::post('/volunteer', [AdminController::class, 'storeVolunteer'])->name('admin.volunteer.store');
        Route::delete('/volunteer/{id}', [RescueController::class, 'deleteVolunteer'])->name('admin.volunteer.delete');

        // D. Manage Inventory (Secure Write Access)
        Route::post('/inventory/add', [InventoryController::class, 'store'])->name('inventory.store');
        Route::post('/inventory/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

        // E. Manage Missing Persons
        Route::post('/missing/toggle/{id}', [MissingPersonController::class, 'toggleStatus'])->name('missing.toggle');
    });
});

require __DIR__.'/auth.php';