<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Password - BedTimeBot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bedtime-cloud font-sans text-bedtime-midnight antialiased flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <div class="absolute top-10 right-10 w-48 h-48 bg-bedtime-yellow rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-10 left-10 w-64 h-64 bg-bedtime-starlight rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="w-full max-w-md bg-white/90 backdrop-blur-xl rounded-[2.5rem] shadow-xl p-8 md:p-10 border border-white/60 relative z-10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-bedtime-blue tracking-tight mb-2">Almost there!</h1>
            <p class="text-gray-500 font-medium text-lg">Secure your account for <strong class="text-gray-800">{{ $user->email }}</strong>.</p>
        </div>

        <form method="POST" action="{{ request()->fullUrl() }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="password" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Create Password</label>
                <input type="password" name="password" id="password" required autofocus
                    class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight">
                @error('password')
                    <p class="text-red-500 text-sm mt-2 font-bold pl-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 pl-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required 
                    class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:bg-white focus:border-bedtime-blue focus:ring-0 transition-colors text-lg font-medium text-bedtime-midnight">
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-bedtime-orange to-orange-400 text-white text-xl font-extrabold py-4 px-8 rounded-[2rem] shadow-magical transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-bedtime-orange">
                    Save & Enter
                </button>
            </div>
        </form>
    </div>
    
</body>
</html>