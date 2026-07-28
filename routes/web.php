<?php

use App\Http\Controllers\Admin\WaitlistController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/waitlist', function (Request $request) {
    $validated = $request->validate([
        'parent_name' => 'required|string|max:255',
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
        'parent_name' => $validated['parent_name'],
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
            return auth()->user()->is_admin ? redirect()->route('admin.dashboard') : redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });

    // Custom Beta Welcome Flow
    Route::get('/welcome/{user}', function (Request $request, App\Models\User $user) {
        if (!$request->hasValidSignature()) {
            abort(401, 'This welcome link has expired or is invalid. Please contact support.');
        }
        return view('auth.setup_password', ['user' => $user]);
    })->name('welcome.setup');

    Route::post('/welcome/{user}', function (Request $request, App\Models\User $user) {
        if (!$request->hasValidSignature()) {
            abort(401, 'This welcome link has expired or is invalid. Please contact support.');
        }

        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        
        return redirect('/')->with('success', 'Your account is ready!');
    })->name('welcome.setup.store');
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
        // Only fetch pending entries!
        $waitlistEntries = DB::table('waitlist_entries')->whereNull('migrated_at')->latest()->get();
        return view('admin.dashboard', compact('waitlistEntries'));
    })->name('dashboard');

    // The new Migration endpoint
    Route::post('/waitlist/{id}/migrate', [WaitlistController::class, 'migrate'])->name('waitlist.migrate');
});