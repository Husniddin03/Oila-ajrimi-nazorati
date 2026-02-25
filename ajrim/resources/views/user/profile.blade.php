@extends('layouts.user')
@section('title', 'Profil')
@section('page-title', 'Profilim')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
        <!-- PROFIL MA'LUMOTLARI -->
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-2">Shaxsiy ma'lumotlar</h3>
            <p class="text-sm text-matn2 mb-6">{{ $resultCount }} ta test topshirildi</p>

            <div class="text-center mb-6">
                <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-gradient-to-br from-aksent to-red-800 flex items-center justify-center text-2xl font-bold text-white">
                    {{ $user->initials }}
                </div>
                <div class="font-playfair text-xl font-semibold text-matn mb-1">{{ $user->name }}</div>
                <div class="text-sm text-matn2">{{ $user->email }}</div>
            </div>

            @if ($errors->updateProfile->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <ul class="space-y-1">
                        @foreach ($errors->updateProfile->all() as $e)
                            <li class="text-red-400 text-sm">• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Ism-familiya</label>
                        <input type="text" name="name" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Telefon</label>
                        <input type="tel" name="phone" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('phone', $user->phone) }}" placeholder="+998 90 000 00 00">
                    </div>
                    <button type="submit" class="w-full bg-aksent hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">💾 Saqlash</button>
                </div>
            </form>
        </div>

        <!-- PAROL O'ZGARTIRISH -->
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-2">Parol o'zgartirish</h3>
            <p class="text-sm text-matn2 mb-6">Xavfsizlik uchun kuchli parol tanlang</p>

            @if ($errors->updatePassword->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <ul class="space-y-1">
                        @foreach ($errors->updatePassword->all() as $e)
                            <li class="text-red-400 text-sm">• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4 mb-6 text-green-400 text-sm">✅ {{ session('success') }}</div>
            @endif

            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Joriy parol</label>
                        <input type="password" name="current_password" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Yangi parol</label>
                        <input type="password" name="password" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="Min 8 belgi" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Parolni tasdiqlang</label>
                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" required>
                    </div>
                    <button type="submit" class="w-full bg-aksent hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">🔐 Parolni o'zgartirish</button>
                </div>
            </form>

            <!-- HISOBDAN CHIQISH -->
            <div class="mt-6 pt-6 border-t border-chegara">
                <div class="text-sm text-matn2 mb-3">Tizimdan chiqish</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2.5 rounded-lg transition-all duration-200">🚪 Chiqish</button>
                </form>
            </div>
        </div>
    </div>
@endsection
