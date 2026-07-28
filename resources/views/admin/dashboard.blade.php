<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Control Center - BedTimeBot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-bedtime-midnight antialiased">
    
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="bg-bedtime-midnight text-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-extrabold tracking-tight">BedTime<span class="text-bedtime-orange">Bot</span></span>
                    <span class="bg-bedtime-blue bg-opacity-45 text-bedtime-starlight text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Admin Control Center</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-300">{{ auth()->user()->email }}</span>
                    <form method="POST" action="{{ route('logout') ?? '#' }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300 font-semibold">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="max-w-7xl mx-auto px-6 py-10 flex-grow w-full">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Waitlist Management Hub</h1>
                    <p class="text-gray-500 mt-1">Review early adopters, analyze preferred core values, and manage beta access.</p>
                </div>
                <div class="flex space-x-3">
                    <!-- Placeholder for CSV export button -->
                    <button class="bg-white border border-gray-300 text-gray-700 font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-gray-50 transition-colors">
                        Export CSV (PII Scrubbed)
                    </button>
                </div>
            </div>

            <!-- Waitlist Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-lg">Waitlist Entries <span class="ml-2 bg-bedtime-blue text-white text-xs px-2.5 py-0.5 rounded-full">{{ count($waitlistEntries) }}</span></h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50 bg-opacity-50">
                                <th class="py-4 px-6">Parent Email</th>
                                <th class="py-4 px-6">Child Name</th>
                                <th class="py-4 px-6">Age</th>
                                <th class="py-4 px-6">Topic / Interest</th>
                                <th class="py-4 px-6">Core Value</th>
                                <th class="py-4 px-6">Tone</th>
                                <th class="py-4 px-6">Joined</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-600">
                            @forelse($waitlistEntries as $entry)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6 font-bold text-bedtime-midnight">{{ $entry->email }}</td>
                                    <td class="py-4 px-6">{{ $entry->child_name ?? '—' }}</td>
                                    <td class="py-4 px-6">{{ $entry->child_age ?? '—' }}</td>
                                    <td class="py-4 px-6">{{ $entry->favorite_topic ?? '—' }}</td>
                                    <td class="py-4 px-6">
                                        @if($entry->core_value)
                                            <span class="bg-blue-50 text-bedtime-blue text-xs font-bold px-3 py-1 rounded-full">{{ $entry->core_value }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($entry->story_tone)
                                            <span class="bg-orange-50 text-bedtime-orange text-xs font-bold px-3 py-1 rounded-full">{{ $entry->story_tone }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-xs text-gray-400">{{ \Carbon\Carbon::parse($entry->created_at)->diffForHumans() }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <button class="text-bedtime-blue hover:text-bedtime-midnight font-bold text-xs uppercase tracking-wider bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Migrate Beta
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-gray-400 font-medium">No waitlist entries found yet. Share your link to start gathering families!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>