<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BetaWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class WaitlistController extends Controller
{
    public function migrate(Request $request, $id)
    {
        // 1. Fetch the entry
        $entry = DB::table('waitlist_entries')->where('id', $id)->first();

        if (!$entry || $entry->migrated_at) {
            return back()->with('error', 'Entry not found or already migrated.');
        }

        try {
            // 2. The Atomic Transaction
            DB::transaction(function () use ($entry, $request, &$user) {
                
                // Handle Duplicates: Check if the parent already has an account
                $user = User::where('email', $entry->email)->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $entry->parent_name,
                        'email' => $entry->email,
                        // Secure, random 32-character password they will never use
                        'password' => bcrypt(Str::random(32)),
                        'is_admin' => false,
                    ]);
                }

                // Create the Child Profile (if name was provided)
                if ($entry->child_name) {
                    $user->children()->create([
                        'name' => $entry->child_name,
                        'age' => $entry->child_age,
                    ]);
                }

                // Update the waitlist entry
                DB::table('waitlist_entries')->where('id', $id)->update([
                    'migrated_at' => now(),
                ]);

                // Create the Audit Log
                DB::table('audit_logs')->insert([
                    'admin_user_id' => auth()->id(),
                    'impersonated_user_id' => $user->id,
                    'reason' => 'Migrated from waitlist entry #' . $entry->id,
                    'ip_address' => $request->ip(),
                    'started_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            // 3. The Auth Handoff (Outside the transaction so it only fires if DB succeeds)
            $signedUrl = URL::temporarySignedRoute(
                'welcome.setup',
                now()->addDays(7), // 7-day expiration per Claude's feedback
                ['user' => $user->id]
            );

            // 4. Send the branded email
            Mail::to($user->email)->send(new BetaWelcomeMail($entry->parent_name, $signedUrl));

            return back()->with('success', "Successfully migrated {$entry->parent_name} and dispatched the Welcome Email!");

        } catch (\Exception $e) {
            // If anything fails (DB or Email), they get an error and we can investigate.
            return back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }
}