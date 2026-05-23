<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HOSHIGRAPH - Pemulihan Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CDN Standalone (Tanpa NPM) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 text-white antialiased">
    <!-- Background Gradient -->
    <div class="fixed inset-0 bg-gradient-to-br from-orange-950/30 via-slate-950 to-slate-950 -z-10"></div>

    <div class="min-h-screen flex flex-col items-center justify-center px-6">
        
        <!-- Box Pemulihan -->
        <div class="w-full max-w-md bg-slate-900/60 border border-slate-800 p-8 rounded-2xl shadow-xl backdrop-blur-md">
            
            <!-- Logo / Header Box -->
            <div class="mb-6 text-center">
                <a href="{{ url('/') }}" class="text-3xl font-black tracking-tighter text-transparent bg-clip-text bg-orange-500">
                    HOSHIGRAPH
                </a>
                <p class="text-sm text-slate-400 mt-2">Pemulihan Akun Petugas</p>
            </div>

            <!-- Keterangan -->
            <div class="mb-6 text-sm text-slate-400 leading-relaxed">
                {{ __('Lupa password? Tidak masalah. Cukup masukkan alamat email Anda di bawah ini, dan kami akan mengirimkan tautan pemulihan melalui email agar Anda bisa memilih password baru.') }}
            </div>

            <!-- Session Status (Notifikasi Sukses Kirim Link Email) -->
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-500 bg-green-500/10 p-4 rounded-xl border border-green-500/20">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email Terdaftar</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all @error('email') border-red-500 @enderror"
                        placeholder="nama@hoshigraph.com">
                    
                    @error('email')
                        <p class="text-sm text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition-all transform hover:scale-[1.02] shadow-lg shadow-orange-500/10 cursor-pointer text-center">
                    {{ __('Kirim Link Pemulihan') }}
                </button>
            </form>
        </div>

        <!-- Back to Login -->
        <a href="{{ route('login') }}" class="mt-6 text-sm text-slate-500 hover:text-slate-300 transition-colors">
            &larr; Kembali ke halaman login
        </a>
    </div>
</body>
</html>