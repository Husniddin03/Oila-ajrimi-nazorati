<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel') — Oila Diagnostika</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-fon text-matn font-dm h-screen overflow-hidden">
    <!-- Mobile Menu Toggle -->
    <button class="lg:hidden fixed top-4 right-4 z-[1001] bg-karta border border-chegara rounded-lg px-3 py-2.5 text-xl text-matn shadow-lg transition-all duration-300 hover:bg-aksent hover:text-white hover:border-aksent" onclick="toggleMobileMenu()">☰</button>
    
    <!-- Mobile Overlay -->
    <div class="hidden fixed inset-0 bg-black/50 z-[999]" onclick="toggleMobileMenu()" id="mobileOverlay"></div>
    
    <div id="appWrapper" class="flex h-screen lg:flex">
        <!-- Sidebar -->
        <aside class="sidebar w-60 flex-shrink-0 bg-fon2 border-r border-chegara flex-col overflow-y-auto h-screen lg:relative fixed -left-full top-0 transition-all duration-300 z-[1000] lg:left-0" id="sidebar">
            <!-- Logo -->
            <div class="sb-logo p-5 pb-4 border-b border-chegara flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-aksent to-red-800 flex items-center justify-center text-lg">🛡️</div>
                <div>
                    <div class="font-playfair text-sm leading-tight">Oila Diagnostika</div>
                    <div class="text-[0.6rem] text-matn2 tracking-[0.06em] uppercase">Admin Panel</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sb-nav p-2 flex-1">
                <div class="text-[0.65rem] text-matn2 font-medium tracking-wider mb-2 px-2">BOSHQARUV</div>
                <a href="{{ route('admin.dashboard') }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">📊</span> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">👥</span> Foydalanuvchilar
                </a>
                
                <div class="text-[0.65rem] text-matn2 font-medium tracking-wider mb-2 px-2 mt-3">TESTLAR</div>
                <a href="{{ route('admin.tests.index') }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.tests.index') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">📋</span> Testlar
                </a>
                <a href="{{ route('admin.tests.questions.index', ['test' => 1]) }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.tests.questions.*') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">❓</span> Savollar
                </a>
                
                <div class="text-[0.65rem] text-matn2 font-medium tracking-wider mb-2 px-2 mt-3">NATIJALAR</div>
                <a href="{{ route('admin.results.index') }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.results.*') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">📊</span> Natijalar
                </a>
                <a href="{{ route('admin.recommendations.index') }}" class="sb-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.recommendations.*') ? 'bg-aksent/20 text-aksent' : 'hover:bg-fon3 text-matn' }}">
                    <span class="sb-item-icon text-base w-[18px] text-center">💡</span> Tavsiyalar
                </a>
            </nav>

            <!-- Profile Section -->
            <div class="sb-profil p-3.5 border-t border-chegara flex items-center gap-2.5">
                <div class="w-8.5 h-8.5 rounded-full bg-gradient-to-br from-aksent to-red-800 flex items-center justify-center text-xs font-bold text-white">
                    {{ Auth::user()->initials }}
                </div>
                <div class="flex-1">
                    <div class="text-[0.84rem] font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-[0.7rem] text-aksent">Administrator</div>
                </div>
            </div>
            
            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mx-1.5 mb-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-matn2 hover:bg-red-500/10 hover:text-red-400 transition-all duration-200">
                    <span>🚪</span> Chiqish
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-wrap flex-1 flex flex-col min-h-screen lg:ml-0 ml-0 pt-16 lg:pt-0">
            <!-- Top Bar -->
            <header class="topbar bg-karta border-b border-chegara px-6 py-4 flex items-center justify-between lg:px-6 lg:py-4">
                <div>
                    <h1 class="text-xl font-semibold text-matn">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-matn2 mt-1">@yield('title', 'Admin Panel')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="sana-chip bg-fon3 px-3 py-1.5 rounded-full text-xs text-matn2">
                        {{ now()->format('d.m.Y') }}
                    </div>
                    <div class="topbar-user bg-fon3 px-3 py-1.5 rounded-lg text-xs text-matn flex items-center gap-2">
                        <span>👤</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content flex-1 p-6 lg:p-6 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.toggle('-left-full');
            sidebar.classList.toggle('left-0');
            overlay.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.add('-left-full');
                sidebar.classList.remove('left-0');
                overlay.classList.add('hidden');
            }
        });

        // Close menu on window resize if desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobileOverlay');
                sidebar.classList.add('-left-full');
                sidebar.classList.remove('left-0');
                overlay.classList.add('hidden');
            }
        });
    </script>
    
    <!-- Toast Notifications -->
    <script>
        function tost(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg z-[9999] transform transition-all duration-300 translate-y-full`;
            
            if (type === 'success') {
                toast.classList.add('bg-yashil', 'text-white');
            } else if (type === 'error') {
                toast.classList.add('bg-aksent', 'text-white');
            } else {
                toast.classList.add('bg-karta', 'text-matn', 'border', 'border-chegara');
            }
            
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-full');
            }, 100);
            
            setTimeout(() => {
                toast.classList.add('translate-y-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>
    @stack('scripts')
</body>
</html>
