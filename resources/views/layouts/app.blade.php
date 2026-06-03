<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{'Hoshigraph - kasir' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN Standalone (Pengganti Vite, Tanpa NPM) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- Alpine.js (Wajib dipasang agar Sidebar Mobile & Dropdown Profile kamu bisa diklik) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-slate-50 text-white min-h-screen">
    <!-- Background Gradient Statis -->
    <div class="fixed inset-0 0 via-slate-950 to-slate-950 -z-10"></div>

    <div class="min-h-screen flex overflow-hidden" x-data="{ sidebarOpen: false }">

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 text-white flex flex-col transition-transform duration-300 transform md:translate-x-0 md:static md:inset-0 shadow-lg">

            <div
                class="p-6 text-2xl font-black tracking-tighter text-transparent bg-clip-text bg-white \ border-b border-slate-800">
                HOSHIGRAPH
            </div>

            <nav class="mt-6 px-4 space-y-2 flex-1">
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">Dashboard</a>
                <a href="{{ route('booking.index') }}"
                    class="block px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">Booking</a>
                <a href="{{ route('kasir.index') }}"
                    class="block px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">Kasir</a>
                <a href="{{ route('data_transaksi.index') }}"
                    class="block px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">Data
                    Transaksi</a>
                <a href="{{ route('item.index') }}"
                    class="block px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">Data
                    Item</a>
                {{-- <a href="{{ route('kasir.index') }}">Kasir</a>
                <a href="{{ route('transaksi.index') }}">Laporan Transaksi</a> --}}

                @if(auth()->user()->role === 'super_admin')
                    <div class="border-t border-gray-750 my-2 pt-2">
                        <span class="text-xs text-gray-400 block px-4 uppercase font-bold">Menu Pemilik</span>
                        <a href="{{ route('staf.index') }}"
                            class="text-orange-400 font-bold hover:text-orange-500 block px-4 py-2 text-sm">
                            👥 Kelola Anggota Staf
                        </a>
                    </div>
                @endif
            </nav>

            <!-- Dropdown Profile (Model Accordion) -->
            <div class="p-4 border-t border-slate-800" x-data="{ userMenuOpen: false }">
                <button @click="userMenuOpen = !userMenuOpen"
                    class="flex items-center w-full px-3 py-2 text-sm text-gray-300 hover:bg-slate-800 rounded-md transition-colors cursor-pointer">
                    <span class="flex-1 text-left font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="userMenuOpen" x-transition class="mt-2 ml-4 space-y-2">
                    <a href="{{ route('profile.edit') }}"
                        class="block text-sm text-gray-400 hover:text-white transition-colors">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="block w-full text-left text-sm text-gray-400 hover:text-red-400 transition-colors cursor-pointer">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Navigation Blade -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>

        <!-- Overlay untuk Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/60 md:hidden"></div>
    </div>
</body>

</html>