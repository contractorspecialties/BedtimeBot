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
        <div class="absolute top-0 left-0 w-64 h-64 bg-bedtime-yellow rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-bedtime-starlight rounded-full mix-blend-multiply filter blur-[100px] opacity-30"></div>

        <!-- Header / Logo Area -->
        <div class="mb-12 text-center relative z-10 pt-8">
            <h1 class="text-6xl md:text-8xl font-extrabold text-bedtime-blue tracking-tighter mb-4 drop-shadow-sm">
                BedTime<span class="text-bedtime-orange">Bot</span>
            </h1>
            <p class="text-2xl md:text-3xl text-bedtime-starlight font-bold tracking-wide">Your ideas come to life.</p>
        </div>

        <!-- Main Content Card -->
        <div class="w-full max-w-3xl bg-white/90 backdrop-blur-xl rounded-[2.5rem] shadow-xl p-8 md:p-12 border border-white/60 relative z-10 mb-10 transition-all duration-300">
            
            <!-- Success Message State -->
            @if (session('success'))
                <div class="bg-gradient-to-br from-bedtime-yellow/30 to-bedtime-yellow/10 border-2 border-bedtime-yellow text-bedtime-midnight px-8 py-12 rounded-3xl text-center transform scale-105 transition-transform duration-500">
                    <div class="text-6xl mb-6 animate-bounce">✨</div>
                    <h2 class="text-3xl font-extrabold mb-3 text-bedtime-blue">You're on the list!</h2>
                    <p class="text-xl font-medium text-gray-600">{{ session('success') }}</p>
                </div>
            @else
                
                <!-- Intro Copy -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight text-gray-800">
                        Kids get the magic.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedtime-blue to-bedtime-starlight">Parents control the meaning.</span>
                    </h2>
                    <p class="text-gray-500 text-lg leading-relaxed font-medium max-w-xl mx-auto">
                        We generate personalized, beautifully illustrated children's stories designed to strengthen the bond between you and your kids. Secure your spot in our upcoming beta.
                    </p>
                </div>

                <!-- Waitlist Form -->
                <form method="POST" action="{{ route('waitlist.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="parent_name" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Your Name <span class="text-bedtime-orange">*</span></label>
                            <input type="text" name="parent_name" id="parent_name" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight placeholder-gray-400 shadow-sm" 
                                placeholder="e.g. Sarah" value="{{ old('parent_name') }}">
                            @error('parent_name')
                                <p class="text-red-500 text-sm mt-2 font-bold pl-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Email Address <span class="text-bedtime-orange">*</span></label>
                            <input type="email" name="email" id="email" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight placeholder-gray-400 shadow-sm" 
                                placeholder="magic@family.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-2 font-bold pl-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="child_name" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Child's First Name</label>
                            <input type="text" name="child_name" id="child_name" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight placeholder-gray-400 shadow-sm" 
                                placeholder="e.g. Lily" value="{{ old('child_name') }}">
                        </div>

                        <div>
                            <label for="child_age" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Child's Age</label>
                            <input type="number" name="child_age" id="child_age" min="1" max="12" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight placeholder-gray-400 shadow-sm" 
                                placeholder="e.g. 5" value="{{ old('child_age') }}">
                        </div>
                    </div>

                    <div>
                        <label for="favorite_topic" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Favorite Topic / Character</label>
                        <input type="text" name="favorite_topic" id="favorite_topic" 
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight placeholder-gray-400 shadow-sm" 
                            placeholder="Astronauts, Dinosaurs, Talking Dogs..." value="{{ old('favorite_topic') }}">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="core_value" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Core Value to Teach</label>
                            <select name="core_value" id="core_value" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight shadow-sm">
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
                            <label for="story_tone" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Story Tone</label>
                            <select name="story_tone" id="story_tone" 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-all duration-200 text-lg font-medium text-bedtime-midnight shadow-sm">
                                <option value="" disabled selected>Select a vibe...</option>
                                <option value="Calming">Calming & Sleepy</option>
                                <option value="Silly">Silly & Fun</option>
                                <option value="Epic">Epic Adventure</option>
                                <option value="Magical">Magical & Dreamy</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-bedtime-orange to-orange-400 text-white text-2xl font-extrabold py-5 px-8 rounded-[2rem] shadow-magical transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-bedtime-orange focus:ring-opacity-50">
                            Join the Waitlist
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-4 pb-12 text-center text-sm text-gray-400 font-medium z-10">
            <p>Designed for connection. No ads, no child-targeted monetization.</p>
        </div>
    </div>
</body>
</html>