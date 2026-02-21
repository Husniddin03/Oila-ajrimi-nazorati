@extends('layouts.admin')
@section('title', 'Yangi foydalanuvchi')
@section('page-title', 'Yangi foydalanuvchi')

@section('content')
    <div style="max-width:600px;">
        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ikkinchi">← Orqaga</a>
        </div>

        <div class="karta">
            <div class="karta-sarlavha" style="margin-bottom:20px;">Yangi foydalanuvchi qo'shish</div>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-guruh" style="grid-column:1/-1;">
                        <label class="form-label">Ism-familiya *</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Telefon</label>
                        <input type="tel" name="phone" class="form-input" value="{{ old('phone') }}"
                            placeholder="+998...">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Rol *</label>
                        <select name="role" class="form-input" required>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Holat *</label>
                        <select name="status" class="form-input" required>
                            <option value="active">Faol</option>
                            <option value="blocked">Bloklangan</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Parol *</label>
                        <input type="password" name="password" class="form-input" placeholder="Min 8 belgi" required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Parolni tasdiqlang *</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
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
