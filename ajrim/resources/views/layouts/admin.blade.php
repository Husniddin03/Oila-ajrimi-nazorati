<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel') — Oila Diagnostika</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --fon: #0d1117;
            --fon2: #161b22;
            --fon3: #1c2333;
            --karta: #21262d;
            --chegara: #30363d;
            --aksent: #e94560;
            --aksent2: #ff6b6b;
            --yashil: #3fb950;
            --sariq: #d29922;
            --moviy: #58a6ff;
            --matn: #e6edf3;
            --matn2: #7d8590;
            --matn3: #484f58;
            --radius: 12px;
            --radius2: 8px;
            --otkish: all .25s cubic-bezier(.4, 0, .2, 1);
            --soya: 0 8px 24px rgba(0, 0, 0, .4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--fon);
            color: var(--matn);
        }

        #appWrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--fon2);
            border-right: 1px solid var(--chegara);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            height: 100vh;
        }

        .sb-logo {
            padding: 20px 18px 16px;
            border-bottom: 1px solid var(--chegara);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--aksent), #c0392b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .sb-logo-nom {
            font-family: 'Playfair Display', serif;
            font-size: .95rem;
            line-height: 1.2;
        }

        .sb-logo-kichik {
            font-size: .6rem;
            color: var(--matn2);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .sb-nav {
            padding: 10px 8px;
            flex: 1;
        }

        .sb-group {
            font-size: .65rem;
            color: var(--matn3);
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 12px 10px 5px;
        }

        .sb-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius2);
            cursor: pointer;
            transition: var(--otkish);
            font-size: .875rem;
            color: var(--matn2);
            border: 1px solid transparent;
            margin-bottom: 2px;
            text-decoration: none;
        }

        .sb-item:hover {
            background: var(--fon3);
            color: var(--matn);
        }

        .sb-item.active {
            background: rgba(233, 69, 96, .12);
            color: var(--aksent);
            border-color: rgba(233, 69, 96, .2);
        }

        .sb-item-icon {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sb-badge {
            margin-left: auto;
            background: var(--aksent);
            color: #fff;
            font-size: .62rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        .sb-profil {
            padding: 14px;
            border-top: 1px solid var(--chegara);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--aksent), #c0392b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 700;
        }

        .sb-profil-ism {
            font-size: .84rem;
            font-weight: 500;
        }

        .sb-profil-rol {
            font-size: .7rem;
            color: var(--aksent);
        }

        .sb-chiqish {
            margin: 0 8px 10px;
            padding: 9px 12px;
            border-radius: var(--radius2);
            border: 1px solid var(--chegara);
            background: transparent;
            color: var(--matn2);
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .84rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--otkish);
            text-align: left;
            width: calc(100% - 16px);
        }

        .sb-chiqish:hover {
            border-color: var(--aksent);
            color: var(--aksent);
        }

        /* MAIN */
        .main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: rgba(22, 27, 34, .9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--chegara);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .topbar-nom {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }

        .topbar-ong {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-user {
            font-size: .82rem;
            color: var(--matn2);
            background: var(--karta);
            border: 1px solid var(--chegara);
            border-radius: var(--radius2);
            padding: 6px 12px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 24px 28px;
        }

        /* KARTALAR */
        .karta {
            background: var(--karta);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--chegara);
        }

        .karta-sarlavha {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        /* GRID */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        /* STAT */
        .stat-quti {
            background: var(--karta);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--chegara);
        }

        .stat-icon {
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .stat-son {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
        }

        .stat-nom {
            font-size: .75rem;
            color: var(--matn2);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .stat-trend {
            font-size: .75rem;
            margin-top: 8px;
        }

        .stat-trend.up {
            color: var(--yashil);
        }

        .stat-trend.down {
            color: var(--aksent);
        }

        /* CHIP */
        .chip {
            display: inline-block;
            font-size: .72rem;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .chip-yashil {
            background: rgba(63, 185, 80, .15);
            color: var(--yashil);
        }

        .chip-qizil {
            background: rgba(233, 69, 96, .15);
            color: var(--aksent);
        }

        .chip-sariq {
            background: rgba(210, 153, 34, .15);
            color: var(--sariq);
        }

        .chip-moviy {
            background: rgba(88, 166, 255, .15);
            color: var(--moviy);
        }

        /* TUGMA */
        .btn {
            padding: 9px 16px;
            border-radius: var(--radius2);
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            font-weight: 500;
            transition: var(--otkish);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-asosiy {
            background: var(--aksent);
            color: #fff;
        }

        .btn-asosiy:hover {
            background: #c0392b;
        }

        .btn-ikkinchi {
            background: var(--fon3);
            color: var(--matn);
            border: 1px solid var(--chegara);
        }

        .btn-ikkinchi:hover {
            border-color: var(--aksent);
            color: var(--aksent);
        }

        .btn-yashil {
            background: rgba(63, 185, 80, .15);
            color: var(--yashil);
            border: 1px solid rgba(63, 185, 80, .2);
        }

        .btn-xavf {
            background: rgba(233, 69, 96, .1);
            color: var(--aksent);
            border: 1px solid rgba(233, 69, 96, .2);
        }

        .btn-xavf:hover {
            background: rgba(233, 69, 96, .2);
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: .78rem;
        }

        /* JADVAL */
        .jadval-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            font-size: .72rem;
            color: var(--matn2);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 10px 12px;
            border-bottom: 1px solid var(--chegara);
        }

        table td {
            padding: 12px 12px;
            border-bottom: 1px solid rgba(48, 54, 61, .5);
            font-size: .875rem;
            vertical-align: middle;
        }

        table tr:hover td {
            background: rgba(28, 35, 51, .4);
        }

        table tr:last-child td {
            border-bottom: none;
        }

        /* INPUT */
        .form-guruh {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: .75rem;
            color: var(--matn2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .form-input {
            width: 100%;
            background: var(--fon3);
            border: 1px solid var(--chegara);
            border-radius: var(--radius2);
            padding: 10px 13px;
            color: var(--matn);
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            outline: none;
            transition: var(--otkish);
        }

        .form-input:focus {
            border-color: var(--aksent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, .1);
        }

        select.form-input option {
            background: var(--fon2);
        }

        .form-xato {
            font-size: .78rem;
            color: var(--aksent);
            margin-top: 4px;
        }

        /* ALERT */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius2);
            font-size: .875rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-ok {
            background: rgba(63, 185, 80, .1);
            border: 1px solid rgba(63, 185, 80, .3);
            color: var(--yashil);
        }

        .alert-err {
            background: rgba(233, 69, 96, .1);
            border: 1px solid rgba(233, 69, 96, .3);
            color: var(--aksent);
        }

        /* SECTION SARLAVHA */
        .section-sarlavha {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-sarlavha h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
        }

        /* PAGINATION */
        .pagination {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 7px 12px;
            border-radius: var(--radius2);
            font-size: .82rem;
            border: 1px solid var(--chegara);
            background: var(--karta);
            color: var(--matn);
            text-decoration: none;
            transition: var(--otkish);
        }

        .pagination a:hover {
            border-color: var(--aksent);
            color: var(--aksent);
        }

        .pagination .active span {
            background: var(--aksent);
            color: #fff;
            border-color: var(--aksent);
        }

        /* FORM ERRORS */
        .form-errors {
            background: rgba(233, 69, 96, .08);
            border: 1px solid rgba(233, 69, 96, .2);
            border-radius: var(--radius2);
            padding: 14px;
            margin-bottom: 16px;
        }

        .form-errors ul {
            list-style: none;
            font-size: .82rem;
            color: var(--aksent);
        }

        .form-errors li::before {
            content: '• ';
            font-weight: 700;
        }

        /* TOST */
        #tostlar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .tost {
            background: var(--karta);
            border-radius: var(--radius2);
            padding: 12px 18px;
            box-shadow: var(--soya);
            border: 1px solid var(--chegara);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .875rem;
            animation: fadeUp .3s ease;
            min-width: 260px;
        }

        .tost.ok {
            border-left: 4px solid var(--yashil);
        }

        .tost.err {
            border-left: 4px solid var(--aksent);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        /* SEARCH BAR */
        .filter-qator {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-qator .form-input {
            flex: 1;
            min-width: 180px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="appWrapper">
        <aside class="sidebar">
            <div class="sb-logo">
                <div class="sb-logo-icon">🛡️</div>
                <div>
                    <div class="sb-logo-nom">Oila Diagnostika</div>
                    <div class="sb-logo-kichik">Admin Panel</div>
                </div>
            </div>

            <nav class="sb-nav">
                <div class="sb-group">BOSHQARUV</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sb-item-icon">📊</span> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="sb-item-icon">👥</span> Foydalanuvchilar
                </a>

                <div class="sb-group">TEST TIZIMI</div>
                <a href="{{ route('admin.tests.index') }}"
                    class="sb-item {{ request()->routeIs('admin.tests.*') && !request()->routeIs('admin.tests.questions.*') ? 'active' : '' }}">
                    <span class="sb-item-icon">📋</span> Testlar
                </a>
                <a href="{{ route('admin.results.index') }}"
                    class="sb-item {{ request()->routeIs('admin.results.*') ? 'active' : '' }}">
                    <span class="sb-item-icon">📈</span> Natijalar
                </a>
                <a href="{{ route('admin.recommendations.index') }}"
                    class="sb-item {{ request()->routeIs('admin.recommendations.*') ? 'active' : '' }}">
                    <span class="sb-item-icon">💡</span> Tavsiyalar
                </a>
            </nav>

            <div class="sb-profil">
                <div class="sb-avatar">{{ auth()->user()->initials }}</div>
                <div>
                    <div class="sb-profil-ism">{{ auth()->user()->name }}</div>
                    <div class="sb-profil-rol">● Admin</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sb-chiqish">
                    <span>🚪</span> Chiqish
                </button>
            </form>
        </aside>

        <div class="main-wrap">
            <header class="topbar">
                <div class="topbar-nom">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-ong">
                    <div class="topbar-user">👤 {{ auth()->user()->name }}</div>
                    <div class="topbar-user">📅 {{ now()->format('d.m.Y') }}</div>
                </div>
            </header>

            <main class="content">
                @if (session('success'))
                    <div class="alert alert-ok">✅ {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-err">❌ {{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <div id="tostlar"></div>

    <script>
        function tost(xabar, tur = 'ok') {
            const k = document.getElementById('tostlar');
            const t = document.createElement('div');
            t.className = 'tost ' + (tur === 'ok' ? 'ok' : 'err');
            t.innerHTML = `<span>${tur === 'ok' ? '✅' : '❌'}</span><span>${xabar}</span>`;
            k.appendChild(t);
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transform = 'translateY(10px)';
                t.style.transition = '.3s';
                setTimeout(() => t.remove(), 300);
            }, 3000);
        }
    </script>
    @stack('scripts')
</body>

</html>
