<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        @include('components.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body> --}}
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- SIDEBAR -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col transition-transform duration-300 transform md:translate-x-0 md:static md:inset-0 shadow-lg">
            
            <div class="p-6 text-2xl font-bold text-orange-500 border-b border-slate-800">
                HOSHIGRAPH
            </div>
            
            <nav class="mt-6 px-4 space-y-2 flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Dashboard</a>
                <a href="{{ route('booking.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Booking</a>
                <a href="{{ route('kasir.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Kasir</a>
                <a href="{{ route('data_transaksi.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">data transaksi</a>
                <a href="{{ route('item.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">data Item</a>
            </nav>

            <!-- Dropdown Profile yang tadi kita bahas (Model Accordion) -->
            <div class="p-4 border-t border-slate-800" x-data="{ userMenuOpen: false }">
                <button @click="userMenuOpen = !userMenuOpen" class="flex items-center w-full px-3 py-2 text-sm text-gray-300 hover:bg-slate-800 rounded-md">
                    <span class="flex-1 text-left">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="userMenuOpen" class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block text-sm text-gray-400 hover:text-white">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-400 hover:text-white">Logout</button>
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
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 md:hidden"></div>
    </div>
</body>

</html>