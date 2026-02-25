<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — Oila Diagnostika</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Background decoration */
        body::before {
            content: '🌿';
            position: fixed;
            font-size: 16rem;
            right: -5%;
            bottom: -10%;
            opacity: 0.03;
            z-index: 0;
        }
    </style>
</head>

<body class="bg-fon text-matn font-dm min-h-screen flex items-center justify-center p-4 lg:p-8">
    <div class="login-quti w-full max-w-md bg-karta border border-chegara rounded-2xl p-8 lg:p-10 relative z-10">
        <!-- Logo Section -->
        <div class="l-logo text-center mb-8">
            <div class="l-belgi w-16 h-16 bg-gradient-to-br from-aksent to-red-800 rounded-2xl flex items-center justify-center text-3xl mb-4 mx-auto">🌿</div>
            <div class="l-nom font-playfair text-2xl lg:text-3xl mb-2">Oila Diagnostika</div>
            <div class="l-kichik text-xs text-matn2 tracking-wider uppercase">Oilaviy munosabatlar tahlil tizimi</div>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Field -->
            <div class="l-qator">
                <label class="l-label block text-xs text-matn2 font-medium mb-2">Email manzil</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="email@example.com"
                    class="l-input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('email') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('email')
                    <div class="l-xato mt-2 text-sm text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg p-3">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="l-qator">
                <label class="l-label block text-xs text-matn2 font-medium mb-2">Parol</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="•••••••••••"
                    class="l-input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('password') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('password')
                    <div class="l-xato mt-2 text-sm text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg p-3">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="l-eslab flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="accent-aksent">
                <label for="remember" class="text-sm text-matn2 cursor-pointer">Meni eslab qolish</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="l-btn w-full bg-aksent hover:bg-red-600 text-white font-medium py-3 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">
                Tizimga kirish
            </button>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="l-xato mt-4 text-sm text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg p-3">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </form>

        <!-- Register Link -->
        <div class="l-link text-center mt-6">
            <p class="text-sm text-matn2">Hisobingiz yo'qmi?</p>
            <a href="{{ route('register') }}" class="text-aksent hover:text-red-400 font-medium transition-colors duration-200">Ro'yxatdan o'tish</a>
        </div>
    </div>
</body>
</html>
