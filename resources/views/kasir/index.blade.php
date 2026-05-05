@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
        Kasir & Manajemen Pembayaran
    </h2>
@endsection

@section('content')
{{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-700">Status Pembayaran Client</h3>
            <div class="flex gap-2">
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Total Lunas: 0</span>
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Total Piutang: 0</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b">
                        <th class="p-4 font-semibold text-slate-600">Coser</th>
                        <th class="p-4 font-semibold text-slate-600">Total Harga</th>
                        <th class="p-4 font-semibold text-slate-600">DP</th>
                        <th class="p-4 font-semibold text-slate-600">Sisa Bayar</th>
                        <th class="p-4 font-semibold text-slate-600 text-center">Status</th>
                        <th class="p-4 font-semibold text-slate-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="p-4 text-sm">Contoh Coser</td>
                        <td class="p-4 text-sm font-mono">Rp 150.000</td>
                        <td class="p-4 text-sm font-mono text-blue-600">Rp 50.000</td>
                        <td class="p-4 text-sm font-mono text-red-600">Rp 100.000</td>
                        <td class="p-4 text-center">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">DP (SETENGAH)</span>
                        </td>
                        <td class="p-4 text-center">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                Update Bayar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}
 <h2 class="font-semibold text-xl text-gray-800 my-3 leading-tight uppercase">
        Kasir & Manajemen Pembayaran
    </h2>
<!-- Contoh Logika di Bagian Atas Kasir -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- KOLOM KIRI: Input & Pemilihan (Span 2) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- 1. Identifikasi Pelanggan -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200" x-data="{ mode: 'ots' }">
            <h3 class="text-lg font-bold text-gray-800 mb-4">1. Identitas Pelanggan</h3>
            <div class="flex p-1 bg-gray-100 rounded-lg w-fit mb-4">
                <button @click="mode = 'ots'" :class="mode === 'ots' ? 'bg-white shadow text-orange-600' : 'text-gray-500'" class="px-4 py-2 rounded-md text-sm font-medium transition">On The Spot (OTS)</button>
                <button @click="mode = 'booking'" :class="mode === 'booking' ? 'bg-white shadow text-orange-600' : 'text-gray-500'" class="px-4 py-2 rounded-md text-sm font-medium transition">Cari Booking</button>
            </div>

            <!-- Form OTS -->
            <div x-show="mode === 'ots'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Nama Pelanggan" class="rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500">
                <input type="text" placeholder="No. WhatsApp (62812...)" class="rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- Form Cari Booking -->
            <div x-show="mode === 'booking'" class="flex space-x-2">
                <input type="text" placeholder="Masukkan Kode Booking atau Nama..." class="flex-1 rounded-lg border-gray-300">
                <button class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700">Cari</button>
            </div>
        </div>
        <!-- Section 2: Penugasan Staff (Kunci Fotocommish) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">2. Kru yang Bertugas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fotografer</label>
                    <select class="w-full rounded-lg border-gray-300">
                        <option>Pilih Fotografer</option>
                        <option>Andika Pratama</option>
                        <option>Siti Rahma</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">kasir</label>
                    <select class="w-full rounded-lg border-gray-300">
                        <option>Pilih Editor</option>
                        <option>Budi Santoso</option>
                        <option>Self-Edit (Pelanggan)</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- 2. Pilih Paket -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">2. Pilih Paket Foto</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Card Paket -->
                <button class="p-4 border-2 border-orange-500 bg-orange-50 rounded-xl text-left transition">
                    <p class="font-bold text-orange-600">Personal Pro</p>
                    <p class="text-xs text-gray-500">1 Orang • 15 Menit</p>
                    <p class="mt-2 font-bold text-gray-800">Rp 150.000</p>
                </button>
                
                <button class="p-4 border border-gray-200 hover:border-orange-500 rounded-xl text-left transition text-gray-700">
                    <p class="font-bold">Group Session</p>
                    <p class="text-xs text-gray-500">Up to 5 Orang • 30 Menit</p>
                    <p class="mt-2 font-bold">Rp 350.000</p>
                </button>

                <button class="p-4 border border-gray-200 hover:border-orange-500 rounded-xl text-left transition text-gray-700">
                    <p class="font-bold">Graduation</p>
                    <p class="text-xs text-gray-500">Keluarga • 45 Menit</p>
                    <p class="mt-2 font-bold">Rp 500.000</p>
                </button>
            </div>
        </div>

        <!-- 3. Add-ons (Ekstra) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">3. Tambahan (Add-ons)</h3>
            <div class="flex flex-wrap gap-3">
                <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" class="text-orange-500 rounded focus:ring-orange-500">
                    <span class="text-sm font-medium">Extra Orang (+Rp 25rb)</span>
                </label>
                <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" class="text-orange-500 rounded focus:ring-orange-500">
                    <span class="text-sm font-medium">Extra Print (+Rp 15rb)</span>
                </label>
                <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="checkbox" class="text-orange-500 rounded focus:ring-orange-500">
                    <span class="text-sm font-medium">Semua File (Softcopy) (+Rp 50rb)</span>
                </label>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: Ringkasan & Pembayaran -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b">Ringkasan Pesanan</h3>
            
            <div class="space-y-4 mb-6">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Personal Pro (x1)</span>
                    <span class="font-semibold text-gray-800">Rp 150.000</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Extra Print (x2)</span>
                    <span class="font-semibold text-gray-800">Rp 30.000</span>
                </div>
                <div class="flex justify-between text-sm text-green-600 font-medium">
                    <span>DP / Deposit (Booking)</span>
                    <span>- Rp 50.000</span>
                </div>
            </div>

            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="text-gray-800">Rp 180.000</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-800">Total Akhir</span>
                    <span class="text-2xl font-black text-orange-600">Rp 130.000</span>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mt-8 space-y-3">
                <label class="block text-sm font-bold text-gray-700">Metode Pembayaran</label>
                <select class="w-full rounded-lg border-gray-300 focus:ring-orange-500">
                    <option>Cash</option>
                    <option>QRIS</option>
                    <option>Transfer Bank</option>
                </select>
                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-orange-200">
                    Selesaikan Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>
@endsection