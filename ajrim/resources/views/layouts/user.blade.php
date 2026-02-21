<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Oila Diagnostika') — Foydalanuvchi Paneli</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --fon: #f7f3ee;
            --fon2: #ffffff;
            --karta: #ffffff;
            --chegara: #e8e2da;
            --asosiy: #2d4a3e;
            --asosiy2: #4a7c59;
            --aksent: #c87941;
            --aksent2: #e8956a;
            --matn: #1a2f25;
            --matn2: #6b8f7a;
            --matn3: #a0b8ac;
            --radius: 16px;
            --radius2: 10px;
            --otkish: all .25s cubic-bezier(.4, 0, .2, 1);
            --soya: 0 4px 20px rgba(45, 74, 62, .08);
            --soya2: 0 12px 40px rgba(45, 74, 62, .14);
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
            font-family: 'Jost', sans-serif;
            background: var(--fon);
            color: var(--matn);
        }

        /* APP WRAPPER */
        #appWrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: var(--asosiy);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        .sb-top {
            padding: 24px 18px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .sb-belgi {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--aksent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .sb-nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            color: #fff;
        }

        .sb-kichik {
            font-size: .68rem;
            color: rgba(255, 255, 255, .45);
            margin-top: 3px;
            letter-spacing: .06em;
        }

        .sb-profil-karta {
            margin: 16px 14px;
            background: rgba(255, 255, 255, .07);
            border-radius: 12px;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .sb-profil-ichki {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .sb-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--aksent), var(--aksent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .9rem;
            color: #fff;
        }

        .sb-ism {
            font-size: .88rem;
            font-weight: 500;
            color: #fff;
        }

        .sb-email {
            font-size: .72rem;
            color: rgba(255, 255, 255, .45);
            margin-top: 2px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 140px;
        }

        .sb-xavf-qator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .72rem;
            color: rgba(255, 255, 255, .5);
        }

        .xavf-bar {
            display: flex;
            gap: 3px;
        }

        .xavf-kub {
            width: 18px;
            height: 7px;
            border-radius: 3px;
        }

        .sb-nav {
            padding: 8px 10px;
            flex: 1;
        }

        .sb-group {
            font-size: .65rem;
            color: rgba(255, 255, 255, .3);
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 12px 10px 5px;
        }

        .sb-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--otkish);
            font-size: .875rem;
            color: rgba(255, 255, 255, .55);
            border: 1px solid transparent;
            margin-bottom: 2px;
            text-decoration: none;
        }

        .sb-item:hover {
            background: rgba(255, 255, 255, .07);
            color: rgba(255, 255, 255, .9);
        }

        .sb-item.active {
            background: rgba(200, 121, 65, .2);
            color: var(--aksent2);
            border-color: rgba(200, 121, 65, .25);
        }

        .sb-icon {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sb-chiqish {
            margin: 0 10px 12px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: transparent;
            color: rgba(255, 255, 255, .4);
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: .84rem;
            display: flex;
            align-items: center;
            gap: 8px;
            width: calc(100% - 20px);
            transition: var(--otkish);
            text-align: left;
        }

        .sb-chiqish:hover {
            color: rgba(255, 120, 120, .8);
            border-color: rgba(255, 120, 120, .2);
        }

        /* MAIN */
        .main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--chegara);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(45, 74, 62, .06);
        }

        .topbar-salom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
        }

        .topbar-salom span {
            color: var(--asosiy);
            font-weight: 700;
        }

        .topbar-ong {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sana-chip {
            font-size: .8rem;
            color: var(--matn2);
            background: var(--fon);
            border: 1px solid var(--chegara);
            border-radius: 8px;
            padding: 6px 13px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px;
        }

        /* KARTALAR */
        .karta {
            background: var(--karta);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--soya);
            border: 1px solid rgba(232, 226, 218, .6);
        }

        .karta-sarlavha {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .karta-tavsif {
            font-size: .82rem;
            color: var(--matn2);
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
            box-shadow: var(--soya);
            border: 1px solid rgba(232, 226, 218, .6);
        }

        .stat-icon {
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .stat-son {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--asosiy);
        }

        .stat-nom {
            font-size: .78rem;
            color: var(--matn2);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        /* XAVF DARAJASI */
        .xavf-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        .xavf-badge.yuqori {
            background: rgba(233, 69, 96, .1);
            color: #e94560;
            border: 1px solid rgba(233, 69, 96, .2);
        }

        .xavf-badge.orta {
            background: rgba(210, 153, 34, .1);
            color: #d29922;
            border: 1px solid rgba(210, 153, 34, .2);
        }

        .xavf-badge.past {
            background: rgba(63, 185, 80, .1);
            color: #3fb950;
            border: 1px solid rgba(63, 185, 80, .2);
        }

        /* TUGMALAR */
        .btn {
            padding: 10px 18px;
            border-radius: var(--radius2);
            border: none;
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: .875rem;
            font-weight: 500;
            transition: var(--otkish);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-asosiy {
            background: var(--asosiy);
            color: #fff;
        }

        .btn-asosiy:hover {
            background: var(--asosiy2);
            transform: translateY(-1px);
        }

        .btn-ikkinchi {
            background: var(--fon);
            color: var(--matn);
            border: 1px solid var(--chegara);
        }

        .btn-ikkinchi:hover {
            border-color: var(--asosiy);
            color: var(--asosiy);
        }

        .btn-aksent {
            background: var(--aksent);
            color: #fff;
        }

        .btn-aksent:hover {
            background: var(--aksent2);
        }

        .btn-xavf {
            background: rgba(233, 69, 96, .1);
            color: #e94560;
            border: 1px solid rgba(233, 69, 96, .2);
        }

        .btn-xavf:hover {
            background: rgba(233, 69, 96, .2);
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
            color: #2e7d32;
        }

        .alert-err {
            background: rgba(233, 69, 96, .1);
            border: 1px solid rgba(233, 69, 96, .3);
            color: #c62828;
        }

        /* INPUT */
        .form-guruh {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: .76rem;
            color: var(--matn2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .form-input {
            width: 100%;
            background: var(--fon);
            border: 1.5px solid var(--chegara);
            border-radius: var(--radius2);
            padding: 11px 14px;
            color: var(--matn);
            font-family: 'Jost', sans-serif;
            font-size: .9rem;
            outline: none;
            transition: var(--otkish);
        }

        .form-input:focus {
            border-color: var(--asosiy);
            box-shadow: 0 0 0 3px rgba(45, 74, 62, .1);
        }

        .form-xato {
            font-size: .78rem;
            color: #e94560;
            margin-top: 4px;
        }

        /* PROGRESS BAR */
        .progress-bar {
            background: var(--chegara);
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width .5s ease;
        }

        /* TEST KARTA */
        .test-karta {
            background: var(--karta);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--soya);
            border: 1px solid rgba(232, 226, 218, .6);
            position: relative;
            overflow: hidden;
            transition: var(--otkish);
        }

        .test-karta:hover {
            box-shadow: var(--soya2);
            transform: translateY(-2px);
        }

        .test-bant {
            height: 4px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .test-emoji {
            font-size: 2rem;
            margin-bottom: 12px;
            margin-top: 8px;
        }

        .test-nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .test-tavsif {
            font-size: .82rem;
            color: var(--matn2);
            margin-bottom: 14px;
            line-height: 1.5;
        }

        .test-meta {
            display: flex;
            gap: 10px;
            margin-bottom: 14px;
        }

        .test-meta-el {
            font-size: .75rem;
            color: var(--matn2);
            background: var(--fon);
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* TARIX */
        .tarix-el {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: var(--fon);
            border-radius: var(--radius2);
            margin-bottom: 8px;
            transition: var(--otkish);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .tarix-el:hover {
            border-color: var(--chegara);
            background: var(--karta);
        }

        .tarix-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .tarix-info {
            flex: 1;
        }

        .tarix-nom {
            font-size: .875rem;
            font-weight: 500;
        }

        .tarix-sana {
            font-size: .75rem;
            color: var(--matn2);
            margin-top: 2px;
        }

        .ts-foiz {
            font-size: 1.1rem;
            font-weight: 700;
            text-align: right;
        }

        .ts-foiz.yaxshi {
            color: #3fb950;
        }

        .ts-foiz.orta {
            color: #d29922;
        }

        .ts-foiz.yomon {
            color: #e94560;
        }

        .ts-daraja {
            font-size: .72rem;
            color: var(--matn2);
            margin-top: 2px;
            text-align: right;
        }

        /* TAVSIYA */
        .tav-karta {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px;
            background: var(--fon);
            border-radius: var(--radius2);
            margin-bottom: 10px;
            border: 1px solid var(--chegara);
        }

        .tav-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .tav-icon.yashil {
            background: rgba(63, 185, 80, .15);
        }

        .tav-icon.sariq {
            background: rgba(210, 153, 34, .15);
        }

        .tav-icon.qizil {
            background: rgba(233, 69, 96, .15);
        }

        .tav-icon.moviy {
            background: rgba(88, 166, 255, .15);
        }

        .tav-nom {
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .tav-txt {
            font-size: .82rem;
            color: var(--matn2);
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .tav-taglar {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .tav-tag {
            font-size: .7rem;
            background: var(--karta);
            border: 1px solid var(--chegara);
            padding: 3px 8px;
            border-radius: 6px;
            color: var(--matn2);
        }

        /* XAVF INFO BANNER */
        .xavf-info {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: var(--radius2);
            margin-bottom: 16px;
        }

        .xavf-info.yuqori {
            background: rgba(233, 69, 96, .08);
            border: 1px solid rgba(233, 69, 96, .2);
        }

        .xavf-info.orta {
            background: rgba(210, 153, 34, .08);
            border: 1px solid rgba(210, 153, 34, .2);
        }

        .xavf-info.past {
            background: rgba(63, 185, 80, .08);
            border: 1px solid rgba(63, 185, 80, .2);
        }

        .xi-icon {
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .xi-nom {
            font-size: .88rem;
            font-weight: 600;
        }

        .xi-txt {
            font-size: .78rem;
            color: var(--matn2);
            margin-top: 3px;
        }

        /* KORSATKICHLAR */
        .korsatkichlar {
            display: flex;
            gap: 10px;
            margin: 16px 0;
        }

        .k-karta {
            flex: 1;
            background: var(--fon);
            border-radius: var(--radius2);
            padding: 14px;
            text-align: center;
        }

        .k-doira {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .95rem;
            margin: 0 auto 8px;
            border: 3px solid;
        }

        .k-doira.yaxshi {
            color: #3fb950;
            border-color: #3fb950;
        }

        .k-doira.orta {
            color: #d29922;
            border-color: #d29922;
        }

        .k-doira.yomon {
            color: #e94560;
            border-color: #e94560;
        }

        .k-nom {
            font-size: .72rem;
            color: var(--matn2);
        }

        /* SCALE SAVOL */
        .scale-qator {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .scale-btn {
            flex: 1;
            padding: 10px 6px;
            border-radius: var(--radius2);
            border: 2px solid var(--chegara);
            background: var(--fon);
            cursor: pointer;
            transition: var(--otkish);
            font-family: 'Jost', sans-serif;
            font-size: .78rem;
            text-align: center;
        }

        .scale-btn:hover {
            border-color: var(--asosiy);
            background: rgba(45, 74, 62, .05);
        }

        .scale-btn.tanlandi {
            border-color: var(--asosiy);
            background: var(--asosiy);
            color: #fff;
        }

        .scale-label {
            font-size: .65rem;
            color: var(--matn2);
            margin-top: 4px;
        }

        /* SECTION SARLAVHA */
        .section-sarlavha {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-sarlavha h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 700;
        }

        /* NATIJA OYNA */
        .natija-oyna {
            text-align: center;
            padding: 40px 20px;
        }

        .natija-emoji {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .natija-nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .natija-tavsif {
            font-size: .9rem;
            color: var(--matn2);
            margin-bottom: 24px;
        }

        .natija-btnlar {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
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
            border-radius: 12px;
            padding: 12px 18px;
            box-shadow: var(--soya2);
            border: 1px solid var(--chegara);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .875rem;
            animation: fadeUp .3s ease;
            min-width: 260px;
        }

        .tost.ok {
            border-left: 4px solid #3fb950;
        }

        .tost.err {
            border-left: 4px solid #e94560;
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
            padding: 8px 12px;
            border-radius: var(--radius2);
            font-size: .82rem;
            border: 1px solid var(--chegara);
            background: var(--karta);
            color: var(--matn);
            text-decoration: none;
            transition: var(--otkish);
        }

        .pagination a:hover {
            border-color: var(--asosiy);
            color: var(--asosiy);
        }

        .pagination .active span {
            background: var(--asosiy);
            color: #fff;
            border-color: var(--asosiy);
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
            color: #e94560;
        }

        .form-errors li::before {
            content: '• ';
            font-weight: 700;
        }

        @media(max-width:768px) {
            .sidebar {
                display: none;
            }

            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="appWrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sb-top">
                <div class="sb-belgi">🌿</div>
                <div class="sb-nom">Oila Diagnostika</div>
                <div class="sb-kichik">FOYDALANUVCHI PANELI</div>
            </div>

            <div class="sb-profil-karta">
                <div class="sb-profil-ichki">
                    <div class="sb-avatar">{{ auth()->user()->initials }}</div>
                    <div>
                        <div class="sb-ism">{{ auth()->user()->name }}</div>
                        <div class="sb-email">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                @php $latest = auth()->user()->latestResult(); @endphp
                @if ($latest)
                    <div class="sb-xavf-qator">
                        <span>Xavf darajasi</span>
                        <div class="xavf-bar">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="xavf-kub"
                                    style="background:{{ $i < ($latest->risk_level === 'high' ? 5 : ($latest->risk_level === 'medium' ? 3 : 1)) ? $latest->risk_color : 'rgba(255,255,255,.1)' }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif
            </div>

            <nav class="sb-nav">
                <div class="sb-group">ASOSIY</div>
                <a href="{{ route('user.dashboard') }}"
                    class="sb-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <span class="sb-icon">🏠</span> Bosh sahifa
                </a>
                <a href="{{ route('user.tests.index') }}"
                    class="sb-item {{ request()->routeIs('user.tests.*') ? 'active' : '' }}">
                    <span class="sb-icon">📋</span> Testlar
                </a>
                <div class="sb-group">NATIJALAR</div>
                <a href="{{ route('user.results.index') }}"
                    class="sb-item {{ request()->routeIs('user.results.*') ? 'active' : '' }}">
                    <span class="sb-icon">📊</span> Natijalar
                </a>
                <div class="sb-group">SOZLAMALAR</div>
                <a href="{{ route('user.profile.show') }}"
                    class="sb-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                    <span class="sb-icon">👤</span> Profil
                </a>
            </nav>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sb-chiqish">
                    <span>🚪</span> Chiqish
                </button>
            </form>
        </aside>

        <!-- MAIN -->
        <div class="main-wrap">
            <header class="topbar">
                <div class="topbar-salom">
                    Assalomu alaykum, <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="topbar-ong">
                    <div class="sana-chip">📅 {{ now()->locale('uz')->isoFormat('D MMMM, YYYY') }}</div>
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

    <!-- TOSTLAR -->
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
