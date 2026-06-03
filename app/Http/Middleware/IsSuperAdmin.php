<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login dan apakah role-nya super_admin
        if (auth()->check() && auth()->user()->role === 'super_admin') {
            return $next($request); // Lolos, boleh masuk
        }

        // Jika bukan super_admin, batalkan akses dan kembalikan ke dashboard
        return redirect()->route('dashboard')->withErrors(['error' => 'Akses ditolak! Hanya Super Admin yang boleh mengakses halaman tersebut.']);
    }
}