@extends('layouts.user')
@section('title', 'Profil')

@section('content')
    <div class="section-sarlavha">
        <h2>👤 Mening profilim</h2>
    </div>

    <div class="grid-2" style="gap:24px;max-width:900px;">
        <!-- PROFIL MA'LUMOTLARI -->
        <div class="karta">
            <div class="karta-sarlavha">Shaxsiy ma'lumotlar</div>
            <div class="karta-tavsif" style="margin-bottom:20px;">{{ $resultCount }} ta test topshirildi</div>

            <div style="text-align:center;margin-bottom:24px;">
                <div
                    style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--asosiy),var(--asosiy2));display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;color:#fff;margin:0 auto 12px;">
                    {{ $user->initials }}
                </div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;">{{ $user->name }}
                </div>
                <div style="font-size:.8rem;color:var(--matn2);">{{ $user->email }}</div>
            </div>

            @if ($errors->updateProfile->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->updateProfile->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-guruh">
                    <label class="form-label">Ism-familiya</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}"
                        required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Telefon</label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}"
                        placeholder="+998 90 000 00 00">
                </div>
                <button type="submit" class="btn btn-asosiy">💾 Saqlash</button>
            </form>
        </div>

        <!-- PAROL O'ZGARTIRISH -->
        <div class="karta">
            <div class="karta-sarlavha">Parol o'zgartirish</div>
            <div class="karta-tavsif" style="margin-bottom:20px;">Xavfsizlik uchun kuchli parol tanlang</div>

            @if ($errors->updatePassword->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->updatePassword->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-ok" style="margin-bottom:16px;">✅ {{ session('success') }}</div>
            @endif

            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-guruh">
                    <label class="form-label">Joriy parol</label>
                    <input type="password" name="current_password" class="form-input" required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Yangi parol</label>
                    <input type="password" name="password" class="form-input" placeholder="Min 8 belgi" required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Parolni tasdiqlang</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                <button type="submit" class="btn btn-aksent">🔐 Parolni o'zgartirish</button>
            </form>

            <!-- HISOBDAN CHIQISH -->
            <div style="margin-top:24px;padding-top:24px;border-top:1px solid var(--chegara);">
                <div style="font-size:.82rem;color:var(--matn2);margin-bottom:12px;">Tizimdan chiqish</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-xavf">🚪 Chiqish</button>
                </form>
            </div>
        </div>
    </div>
@endsection
