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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300 font-semibold transition-colors">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="max-w-7xl mx-auto px-6 py-10 flex-grow w-full">
            
            <!-- Alert States -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0"><span class="text-green-500 font-bold">✓</span></div>
                        <div class="ml-3"><p class="text-sm text-green-700 font-medium">{{ session('success') }}</p></div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0"><span class="text-red-500 font-bold">⚠</span></div>
                        <div class="ml-3"><p class="text-sm text-red-700 font-medium">{{ session('error') }}</p></div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Waitlist Management Hub</h1>
                    <p class="text-gray-500 mt-1">Review pending early adopters and securely migrate them to active beta accounts.</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-white border border-gray-300 text-gray-700 font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-gray-50 transition-colors">
                        Export CSV (PII Scrubbed)
                    </button>
                </div>
            </div>

            <!-- Waitlist Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-lg">Pending Waitlist Entries <span class="ml-2 bg-bedtime-blue text-white text-xs px-2.5 py-0.5 rounded-full">{{ count($waitlistEntries) }}</span></h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50 bg-opacity-50">
                                <th class="py-4 px-6">Parent</th>
                                <th class="py-4 px-6">Child</th>
                                <th class="py-4 px-6">Topic / Interest</th>
                                <th class="py-4 px-6">Core Value</th>
                                <th class="py-4 px-6">Tone</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-600">
                            @forelse($waitlistEntries as $entry)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-bedtime-midnight">{{ $entry->parent_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $entry->email }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-700">{{ $entry->child_name ?? '—' }}</div>
                                        <div class="text-xs text-gray-400">Age: {{ $entry->child_age ?? '—' }}</div>
                                    </td>
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
                                    <td class="py-4 px-6 text-right">
                                        <!-- Safe form submission with JS double-submit protection -->
                                        <form method="POST" action="{{ route('admin.waitlist.migrate', $entry->id) }}" onsubmit="let btn = this.querySelector('button'); btn.disabled = true; btn.innerHTML = 'Migrating...'; btn.classList.add('opacity-50', 'cursor-not-allowed');">
                                            @csrf
                                            <button type="submit" class="text-bedtime-blue hover:text-white font-bold text-xs uppercase tracking-wider bg-blue-50 hover:bg-bedtime-blue px-4 py-2 rounded-lg transition-colors">
                                                Migrate to Beta
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400 font-medium">The queue is empty! Share your link to start gathering families.</td>
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