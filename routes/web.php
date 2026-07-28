<?php

use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// --- Authentication Routes ---
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Send admins to the dashboard, anyone else to the homepage
            return auth()->user()->is_admin ? redirect()->route('admin.dashboard') : redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// --- Admin Control Center Routes ---
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () {
        $waitlistEntries = DB::table('waitlist_entries')->latest()->get();
        return view('admin.dashboard', compact('waitlistEntries'));
    })->name('dashboard');

});