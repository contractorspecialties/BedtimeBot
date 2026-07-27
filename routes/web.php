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
        'child_age' => 'nullable|integer|min:1|max:12',
        'favorite_topic' => 'nullable|string|max:255',
    ], [
        'email.unique' => 'You are already on the waitlist! We will notify you as soon as spots open up.',
    ]);

    DB::table('waitlist_entries')->insert([
        'email' => $validated['email'],
        'child_age' => $validated['child_age'] ?? null,
        'favorite_topic' => $validated['favorite_topic'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', "You're on the list! We can't wait to share the magic with your family.");
})->name('waitlist.store');