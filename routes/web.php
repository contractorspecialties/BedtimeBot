<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/waitlist', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|unique:waitlist_entries,email',
        'child_name' => 'nullable|string|max:255',
        'child_age' => 'nullable|integer|min:1|max:12',
        'favorite_topic' => 'nullable|string|max:255',
        'core_value' => 'nullable|string|max:255',
        'story_tone' => 'nullable|string|max:255',
    ], [
        'email.unique' => 'You are already on the waitlist! We will notify you as soon as spots open up.',
    ]);

    DB::table('waitlist_entries')->insert([
        'email' => $validated['email'],
        'child_name' => $validated['child_name'] ?? null,
        'child_age' => $validated['child_age'] ?? null,
        'favorite_topic' => $validated['favorite_topic'] ?? null,
        'core_value' => $validated['core_value'] ?? null,
        'story_tone' => $validated['story_tone'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', "You're on the list! We can't wait to share the magic with your family.");
})->name('waitlist.store');

// Admin Control Center Routes (Protected by Auth and Admin Check)
Route::middleware(['auth', function ($request, $next) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access to the Admin Control Center.');
    }
    return $next($request);
}])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () {
        $waitlistEntries = DB::table('waitlist_entries')->latest()->get();
        return view('admin.dashboard', compact('waitlistEntries'));
    })->name('dashboard');

});

// This brings back all the Laravel Breeze login/logout routes!
require __DIR__.'/auth.php';