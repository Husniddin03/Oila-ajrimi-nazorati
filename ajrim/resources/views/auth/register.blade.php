<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ro'yxatdan o'tish — Oila Diagnostika</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --asosiy: #2d4a3e;
            --asosiy2: #4a7c59;
            --aksent: #c87941;
            --fon: #f7f3ee;
            --fon2: #fff;
            --chegara: #e8e2da;
            --matn: #1a2f25;
            --matn2: #6b8f7a;
            --radius2: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(135deg, var(--asosiy), var(--asosiy2));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .quti {
            background: var(--fon2);
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
            animation: fadeUp .5s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .belgi {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--asosiy), var(--asosiy2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 12px;
        }

        .nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            color: var(--matn);
            font-weight: 700;
        }

        .kichik {
            font-size: .78rem;
            color: var(--matn2);
        }

        .qator {
            margin-bottom: 14px;
        }

        .label {
            display: block;
            font-size: .75rem;
            color: var(--matn2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .input {
            width: 100%;
            background: var(--fon);
            border: 1.5px solid var(--chegara);
            border-radius: var(--radius2);
            padding: 11px 14px;
            color: var(--matn);
            font-family: 'Jost', sans-serif;
            font-size: .9rem;
            outline: none;
            transition: all .25s;
        }

        .input:focus {
            border-color: var(--asosiy);
            box-shadow: 0 0 0 3px rgba(45, 74, 62, .1);
        }

        .input.xato {
            border-color: #e94560;
        }

        .xato-matn {
            font-size: .75rem;
            color: #e94560;
            margin-top: 4px;
        }

        .btn {
            width: 100%;
            background: var(--asosiy);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: var(--radius2);
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            margin-top: 6px;
            transition: all .25s;
        }

        .btn:hover {
            background: var(--asosiy2);
            transform: translateY(-1px);
        }

        .link {
            text-align: center;
            margin-top: 18px;
            font-size: .82rem;
            color: var(--matn2);
        }

        .link a {
            color: var(--aksent);
            text-decoration: none;
            font-weight: 500;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
    </style>
</head>

<body>
    <div class="quti">
        <div class="logo">
            <div class="belgi">🌿</div>
            <div class="nom">Ro'yxatdan o'tish</div>
            <div class="kichik">Oila Diagnostika tizimiga xush kelibsiz</div>
        </div>

        @if ($errors->any())
            <div
                style="background:rgba(200,121,65,.12);border:1px solid rgba(200,121,65,.3);border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:.84rem;color:var(--aksent);">
                @foreach ($errors->all() as $err)
                    <div>• {{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="qator">
                <label class="label">Ism-familiya *</label>
                <input type="text" name="name" class="input {{ $errors->has('name') ? 'xato' : '' }}"
                    value="{{ old('name') }}" placeholder="Abdullayev Ali" required>
                @error('name')
                    <div class="xato-matn">{{ $message }}</div>
                @enderror
            </div>
            <div class="qator">
                <label class="label">Email manzil *</label>
                <input type="email" name="email" class="input {{ $errors->has('email') ? 'xato' : '' }}"
                    value="{{ old('email') }}" placeholder="misol@email.com" required>
                @error('email')
                    <div class="xato-matn">{{ $message }}</div>
                @enderror
            </div>
            <div class="qator">
                <label class="label">Telefon raqam</label>
                <input type="tel" name="phone" class="input" value="{{ old('phone') }}"
                    placeholder="+998 90 000 00 00">
            </div>
            <div class="grid-2">
                <div class="qator">
                    <label class="label">Parol *</label>
                    <input type="password" name="password" class="input {{ $errors->has('password') ? 'xato' : '' }}"
                        placeholder="Min 8 belgi" required>
                    @error('password')
                        <div class="xato-matn">{{ $message }}</div>
                    @enderror
                </div>
                <div class="qator">
                    <label class="label">Parolni tasdiqlang</label>
                    <input type="password" name="password_confirmation" class="input" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn">Ro'yxatdan o'tish →</button>
        </form>

        <div class="link">
            Hisobingiz bormi? <a href="{{ route('login') }}">Kirish</a>
        </div>
    </div>
</body>

</html>
