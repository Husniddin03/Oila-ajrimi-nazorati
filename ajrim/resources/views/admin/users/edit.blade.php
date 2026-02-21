@extends('layouts.admin')
@section('title', 'Foydalanuvchi tahrirlash')
@section('page-title', 'Foydalanuvchi tahrirlash')

@section('content')
    <div style="max-width:600px;">
        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ikkinchi">← Orqaga</a>
        </div>

        <div class="karta">
            <div class="karta-sarlavha" style="margin-bottom:20px;">{{ $user->name }} ni tahrirlash</div>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-guruh" style="grid-column:1/-1;">
                        <label class="form-label">Ism-familiya *</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}"
                            required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}"
                            required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Telefon</label>
                        <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Rol *</label>
                        <select name="role" class="form-input" required>
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Holat *</label>
                        <select name="status" class="form-input" required>
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Faol</option>
                            <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Bloklangan</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Yangi parol (ixtiyoriy)</label>
                        <input type="password" name="password" class="form-input"
                            placeholder="Bo'sh qoldiring (o'zgarmaydi)">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Parolni tasdiqlang</label>
                        <input type="password" name="password_confirmation" class="form-input">
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn btn-asosiy">💾 Saqlash</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-ikkinchi">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
