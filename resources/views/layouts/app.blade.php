<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LaporinYuk! - Sistem Pengaduan Digital' }}</title>

    <!-- Google Fonts: Fredoka & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-playful-dots font-body text-slate-800 antialiased selection:bg-yellow-300 selection:text-slate-900 flex flex-col justify-between">

    <!-- FLOATING PILL NAVBAR -->
    <header class="sticky top-4 z-50 px-4 sm:px-8 max-w-7xl mx-auto w-full">
        <nav class="bg-white/95 backdrop-blur border-2 border-slate-900 rounded-full px-5 py-3 neo-shadow-static flex items-center justify-between transition-all">
            <!-- Brand Logo -->
            <a href="{{ route('reports.index') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-2xl bg-yellow-400 border-2 border-slate-900 flex items-center justify-center font-heading font-black text-xl text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] group-hover:rotate-6 transition-transform">
                    📢
                </div>
                <div>
                    <span class="font-heading font-bold text-xl sm:text-2xl text-slate-900 tracking-tight flex items-center gap-1">
                        Laporin<span class="text-purple-600">Yuk!</span>
                    </span>
                    <span class="hidden sm:inline-block text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 border border-purple-300">
                        E-Report
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="flex items-center gap-2 sm:gap-4">
                @auth
                    <a href="{{ route('reports.index') }}" 
                       class="px-3.5 py-1.5 rounded-full text-sm font-bold border-2 {{ request()->routeIs('reports.index') ? 'bg-purple-600 text-white border-slate-900 neo-shadow-sm' : 'text-slate-700 border-transparent hover:border-slate-900 hover:bg-slate-100' }} transition">
                        🏠 Beranda
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-3.5 py-1.5 rounded-full text-sm font-bold border-2 {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-400 text-slate-900 border-slate-900 neo-shadow-sm' : 'text-slate-700 border-transparent hover:border-slate-900 hover:bg-yellow-100' }} transition">
                            ⚡ Panel Admin
                        </a>
                    @endif

                    <!-- User Pill Badge -->
                    <div class="hidden md:flex items-center gap-2 pl-2 border-l-2 border-slate-200">
                        <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-emerald-300 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left text-xs leading-tight">
                            <p class="font-extrabold text-slate-900 truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] font-semibold text-purple-600 uppercase">{{ auth()->user()->role }}</span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                title="Keluar Akun"
                                class="px-3 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border-2 border-slate-900 neo-shadow-sm hover:bg-rose-200 transition cursor-pointer">
                            Keluar 🚪
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-full text-sm font-bold border-2 border-slate-900 bg-yellow-400 text-slate-900 neo-shadow-sm hover:bg-yellow-300 transition">
                        Masuk 🔑
                    </a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-1.5 rounded-full text-sm font-bold border-2 border-slate-900 bg-purple-600 text-white neo-shadow-sm hover:bg-purple-700 transition">
                        Daftar 🚀
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="w-full max-w-7xl mx-auto px-4 sm:px-8 py-6 flex-1">
        <!-- Toast / Flash alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-100 border-2 border-slate-900 neo-shadow-static flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <p class="font-bold text-emerald-950 text-sm sm:text-base">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-2xl bg-sky-100 border-2 border-slate-900 neo-shadow-static flex items-center gap-3">
                <span class="text-2xl">ℹ️</span>
                <p class="font-bold text-sky-950 text-sm sm:text-base">{{ session('info') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-100 border-2 border-slate-900 neo-shadow-static flex items-center gap-3">
                <span class="text-2xl">⚠️</span>
                <p class="font-bold text-rose-950 text-sm sm:text-base">{{ session('error') }}</p>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto py-8 text-center border-t-2 border-slate-900 bg-white/70">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-600">
            <div class="flex items-center gap-2">
                <span class="font-heading font-bold text-base text-slate-900">📢 LaporinYuk!</span>
                <span>— Platform Pengaduan Warga Pintar & Ceria</span>
            </div>
            <div>
                Crafted with <span class="text-rose-500">❤️</span> by spinach for paneer
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
