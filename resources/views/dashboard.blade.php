@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-2">
    <div class="mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-wider">
            Dashboard Hoshigraph Studio
        </h2>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali! Berikut ringkasan operasional tokomu.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-xl font-black text-gray-800 mt-1 block">Rp {{ number_format($omsetTotal, 0, ',', '.') }}</span>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg text-orange-600 font-bold text-lg">💰</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Transaksi Sukses</span>
                <span class="text-xl font-black text-gray-800 mt-1 block">{{ $totalTransaksiSukses }} Nota</span>
            </div>
            <div class="p-3 bg-green-100 rounded-lg text-green-600 font-bold text-lg">✅</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Antrean Pending</span>
                <span class="text-xl font-black text-gray-800 mt-1 block">{{ $totalPendingBooking }} Sesi</span>
            </div>
            <div class="p-3 bg-yellow-100 rounded-lg text-yellow-600 font-bold text-lg">⏳</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Layanan Layanan</span>
                <span class="text-xl font-black text-gray-800 mt-1 block">{{ $totalProduk }} Produk</span>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 font-bold text-lg">📸</div>
        </div>
    </div>

    <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <h3 class="text-lg font-bold text-orange-400">Butuh Melayani Pelanggan Sekarang?</h3>
            <p class="text-xs text-gray-400 mt-1">Pilih menu kasir untuk memproses pembayaran cepat atau buka daftar pesanan.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kasir.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-4 py-2 rounded-lg text-xs transition">
                🚀 Buka Mesin Kasir
            </a>
            <a href="{{ route('booking.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition">
                + Booking Baru
            </a>
        </div>
    </div>
</div>
@endsection