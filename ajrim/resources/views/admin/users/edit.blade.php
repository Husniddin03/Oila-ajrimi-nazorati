@extends('layouts.admin')
@section('title', 'Foydalanuvchi tahrirlash')
@section('page-title', 'Foydalanuvchi tahrirlash')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-5">
            <a href="{{ route('admin.users.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">← Orqaga</a>
        </div>

        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-6">{{ $user->name }} ni tahrirlash</h3>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $e)
                            <li class="text-red-400 text-sm">• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-matn2 mb-2">Ism-familiya *</label>
                        <input type="text" name="name" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Email *</label>
                        <input type="email" name="email" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Telefon</label>
                        <input type="tel" name="phone" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Rol *</label>
                        <select name="role" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" required>
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Holat *</label>
                        <select name="status" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" required>
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Faol</option>
                            <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Bloklangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Yangi parol (ixtiyoriy)</label>
                        <input type="password" name="password" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="Bo'sh qoldiring (o'zgarmaydi)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Parolni tasdiqlang</label>
                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">💾 Saqlash</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-6 py-2.5 rounded-lg transition-all duration-200">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
