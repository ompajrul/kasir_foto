<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CDN Standalone (Solusi instan tanpa NPM / Vite) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 text-white antialiased">
    <!-- Background Gradient -->
    <div class="fixed inset-0 bg-gradient-to-br from-orange-950/30 via-slate-950 to-slate-950 -z-10"></div>

    <div class="min-h-screen flex flex-col items-center justify-center px-6">
        <!-- Logo / Title -->
        <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-4 text-transparent bg-clip-text bg-orange-500">
            HOSHIGRAPH
        </h1>
        
        <!-- Tagline -->
        <p class="text-lg md:text-xl text-slate-400 mb-10 text-center max-w-lg">
            Professional Photography & Videography Services. <br>
            Capturing your best moments, one frame at a time.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row gap-4 w-full max-w-md justify-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl text-center transition-all transform hover:scale-105 shadow-lg shadow-orange-500/20">
                    Masuk ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white hover:bg-gray-200 text-black font-bold rounded-xl text-center transition-all transform hover:scale-105">
                    Petugas Login
                </a>
            @endauth
        </div>

        <!-- Footer -->
        <footer class="absolute bottom-8 text-slate-500 text-sm">
            &copy; {{ date('Y') }} HOSHIGRAPH - Surabaya, Indonesia.
        </footer>
    </div>
</body>
</html>