<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register — Oila Diagnostika</title>
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
    <div class="quti w-full max-w-md bg-karta border border-chegara rounded-2xl p-8 lg:p-10 relative z-10">
        <!-- Logo Section -->
        <div class="logo text-center mb-8">
            <div class="belgi w-14 h-14 bg-gradient-to-br from-aksent to-red-800 rounded-2xl flex items-center justify-center text-2xl mb-3 mx-auto">🌿</div>
            <div class="nom font-playfair text-xl lg:text-2xl mb-2">Ro'yxatdan o'tish</div>
            <div class="kichik text-xs text-matn2 tracking-wider uppercase">Oila Diagnostika tizimiga xush kelibsiz</div>
        </div>

        <!-- Register Form -->
        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name Field -->
            <div class="qator">
                <label class="label block text-xs text-matn2 font-medium mb-2">Ism-familiya *</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Abdullayev Ali"
                    required
                    class="input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('name') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('name')
                    <div class="xato-matn mt-1 text-xs text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="qator">
                <label class="label block text-xs text-matn2 font-medium mb-2">Email *</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="email@example.com"
                    required
                    class="input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('email') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('email')
                    <div class="xato-matn mt-1 text-xs text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="qator">
                <label class="label block text-xs text-matn2 font-medium mb-2">Parol *</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="•••••••••••"
                    class="input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('password') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('password')
                    <div class="xato-matn mt-1 text-xs text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="qator">
                <label class="label block text-xs text-matn2 font-medium mb-2">Parolni tasdiqlang *</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    placeholder="•••••••••••"
                    class="input w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200 {{ $errors->has('password_confirmation') ? 'border-red-500 bg-red-500/10' : '' }}"
                >
                @error('password_confirmation')
                    <div class="xato-matn mt-1 text-xs text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn w-full bg-aksent hover:bg-red-600 text-white font-medium py-3 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 mt-4">
                Ro'yxatdan o'tish
            </button>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-4">
                    @foreach ($errors->all() as $error)
                        <div class="text-red-400 text-sm">• {{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </form>

        <!-- Login Link -->
        <div class="link text-center mt-6">
            <p class="text-sm text-matn2">Allaqachon hisobingiz bormi?</p>
            <a href="{{ route('login') }}" class="text-aksent hover:text-red-400 font-medium transition-colors duration-200">Tizimga kirish</a>
        </div>
    </div>
</body>
</html>
