<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BedTimeBot - Your ideas come to life</title>
    
    <!-- Vite handles compiling our Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bedtime-cloud font-sans text-bedtime-midnight antialiased selection:bg-bedtime-yellow selection:text-bedtime-midnight">
    
    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
        
        <!-- Decorative Background Elements -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-bedtime-yellow rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-bedtime-starlight rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

        <!-- Header / Logo Area -->
        <div class="mb-10 text-center relative z-10 pt-10">
            <h1 class="text-6xl md:text-7xl font-extrabold text-bedtime-blue tracking-tight mb-2 drop-shadow-sm">
                BedTime<span class="text-bedtime-orange">Bot</span>
            </h1>
            <p class="text-2xl text-bedtime-starlight font-bold tracking-wide">Your ideas come to life</p>
        </div>

        <!-- Main Content Card -->
        <div class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-soft p-8 md:p-12 border-[6px] border-white relative z-10 mb-10">
            
            <!-- Success Message State -->
            @if (session('success'))
                <div class="bg-bedtime-yellow bg-opacity-20 border-2 border-bedtime-yellow text-bedtime-midnight px-6 py-8 rounded-3xl text-center">
                    <div class="text-5xl mb-4">✨</div>
                    <h2 class="text-2xl font-bold mb-2">You're on the list!</h2>
                    <p class="text-lg font-medium">{{ session('success') }}</p>
                </div>
            @else
                
                <!-- Intro Copy -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-5 leading-tight">
                        Kids get the magic.<br>
                        <span class="text-bedtime-blue">Parents control the meaning.</span>
                    </h2>
                    <p class="text-gray-500 text-lg md:text-xl leading-relaxed font-medium">
                        A new kind of storytelling platform. We generate personalized, beautifully illustrated children's stories designed to strengthen the bond between you and your kids.
                    </p>
                </div>

                <!-- Waitlist Form -->
                <form method="POST" action="{{ route('waitlist.store') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Parent's Email Address <span class="text-bedtime-orange">*</span></label>
                        <input type="email" name="email" id="email" required 
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight placeholder-gray-300" 
                            placeholder="magic@family.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-2 font-bold pl-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="child_name" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Child's First Name</label>
                            <input type="text" name="child_name" id="child_name" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight placeholder-gray-300" 
                                placeholder="e.g. Lily" value="{{ old('child_name') }}">
                        </div>

                        <div>
                            <label for="child_age" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Child's Age</label>
                            <input type="number" name="child_age" id="child_age" min="1" max="12" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight placeholder-gray-300" 
                                placeholder="e.g. 5" value="{{ old('child_age') }}">
                        </div>
                    </div>

                    <div>
                        <label for="favorite_topic" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Favorite Topic / Character</label>
                        <input type="text" name="favorite_topic" id="favorite_topic" 
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight placeholder-gray-300" 
                            placeholder="Astronauts, Dinosaurs, Talking Dogs..." value="{{ old('favorite_topic') }}">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="core_value" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Core Value to Teach</label>
                            <select name="core_value" id="core_value" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight">
                                <option value="" disabled selected>Select a lesson...</option>
                                <option value="Bravery">Bravery & Courage</option>
                                <option value="Kindness">Kindness & Sharing</option>
                                <option value="Patience">Patience</option>
                                <option value="Curiosity">Curiosity & Learning</option>
                                <option value="Honesty">Honesty</option>
                                <option value="Self-Confidence">Self-Confidence</option>
                            </select>
                        </div>

                        <div>
                            <label for="story_tone" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Story Tone</label>
                            <select name="story_tone" id="story_tone" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight">
                                <option value="" disabled selected>Select a vibe...</option>
                                <option value="Calming">Calming & Sleepy</option>
                                <option value="Silly">Silly & Fun</option>
                                <option value="Epic">Epic Adventure</option>
                                <option value="Magical">Magical & Dreamy</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                            class="w-full bg-bedtime-orange text-white text-2xl font-extrabold py-5 px-8 rounded-[2rem] shadow-magical transform transition-all hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-bedtime-orange focus:ring-opacity-50">
                            Join the Waitlist
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-4 pb-10 text-center text-sm text-gray-400 font-medium z-10">
            <p>Designed for connection. No ads, no child-targeted monetization.</p>
        </div>
    </div>
</body>
</html>