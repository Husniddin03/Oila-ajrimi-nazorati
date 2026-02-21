<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kirish — Oila Diagnostika</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --asosiy: #2d4a3e;
            --asosiy2: #4a7c59;
            --aksent: #c87941;
            --aksent2: #e8956a;
            --fon: #f7f3ee;
            --fon2: #ffffff;
            --chegara: #e8e2da;
            --matn: #1a2f25;
            --matn2: #6b8f7a;
            --radius: 16px;
            --radius2: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(135deg, var(--asosiy) 0%, var(--asosiy2) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '🌿';
            font-size: 20rem;
            position: absolute;
            right: -5%;
            bottom: -10%;
            opacity: .05;
            pointer-events: none;
        }

        .login-quti {
            background: var(--fon2);
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
            animation: fadeUp .5s ease;
            position: relative;
            z-index: 1;
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

        .l-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .l-belgi {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--asosiy), var(--asosiy2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 14px;
        }

        .l-nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            color: var(--matn);
            font-weight: 700;
        }

        .l-kichik {
            font-size: .78rem;
            color: var(--matn2);
            margin-top: 4px;
        }

        .l-qator {
            margin-bottom: 14px;
        }

        .l-label {
            display: block;
            font-size: .76rem;
            color: var(--matn2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .l-input {
            width: 100%;
            background: var(--fon);
            border: 1.5px solid var(--chegara);
            border-radius: var(--radius2);
            padding: 12px 14px;
            color: var(--matn);
            font-family: 'Jost', sans-serif;
            font-size: .9rem;
            outline: none;
            transition: all .25s;
        }

        .l-input:focus {
            border-color: var(--asosiy);
            box-shadow: 0 0 0 3px rgba(45, 74, 62, .1);
        }

        .l-btn {
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

        .l-btn:hover {
            background: var(--asosiy2);
            transform: translateY(-1px);
        }

        .l-xato {
            background: rgba(200, 121, 65, .12);
            border: 1px solid rgba(200, 121, 65, .3);
            border-radius: var(--radius2);
            padding: 10px 14px;
            font-size: .84rem;
            color: var(--aksent);
            margin-bottom: 14px;
        }

        .l-link {
            text-align: center;
            margin-top: 18px;
            font-size: .82rem;
            color: var(--matn2);
        }

        .l-link a {
            color: var(--aksent);
            text-decoration: none;
            font-weight: 500;
        }

        .l-link a:hover {
            text-decoration: underline;
        }

        .l-eslab {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .82rem;
            color: var(--matn2);
            margin-top: 10px;
        }

        .l-eslab input {
            accent-color: var(--asosiy);
        }
    </style>
</head>

<body>
    <div class="login-quti">
        <div class="l-logo">
            <div class="l-belgi">🌿</div>
            <div class="l-nom">Oila Diagnostika</div>
            <div class="l-kichik">Oilaviy munosabatlar tahlil tizimi</div>
        </div>

        @if ($errors->any())
            <div class="l-xato">
                @foreach ($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="l-qator">
                <label class="l-label">Email manzil</label>
                <input type="email" name="email" class="l-input" value="{{ old('email') }}"
                    placeholder="misol@email.com" required autofocus>
            </div>
            <div class="l-qator">
                <label class="l-label">Parol</label>
                <input type="password" name="password" class="l-input" placeholder="••••••••" required>
            </div>
            <label class="l-eslab">
                <input type="checkbox" name="remember"> Meni eslab qol
            </label>
            <button type="submit" class="l-btn">Kirish →</button>
        </form>

        <div class="l-link">
            Hisobingiz yo'qmi? <a href="{{ route('register') }}">Ro'yxatdan o'ting</a>
        </div>
    </div>
</body>

</html>
