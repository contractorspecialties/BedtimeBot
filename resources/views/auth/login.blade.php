<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - BedTimeBot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bedtime-cloud font-sans text-bedtime-midnight antialiased selection:bg-bedtime-yellow selection:text-bedtime-midnight flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <!-- Decorative Background Elements -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-bedtime-yellow rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-48 h-48 bg-bedtime-starlight rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-soft p-8 md:p-10 border-[6px] border-white relative z-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-bedtime-blue tracking-tight mb-2 drop-shadow-sm">
                BedTime<span class="text-bedtime-orange">Bot</span>
            </h1>
            <p class="text-gray-500 font-medium text-lg">Welcome back</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Email Address</label>
                <input type="email" name="email" id="email" required autofocus
                    class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight placeholder-gray-300" 
                    placeholder="magic@family.com" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-2 font-bold pl-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 pl-2">Password</label>
                <input type="password" name="password" id="password" required 
                    class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight">
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-bedtime-blue text-white text-xl font-extrabold py-4 px-8 rounded-[2rem] shadow-magical transform transition-all hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-bedtime-blue focus:ring-opacity-50">
                    Sign In
                </button>
            </div>
        </form>
    </div>
    
</body>
</html>