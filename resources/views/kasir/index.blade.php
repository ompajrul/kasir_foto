@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Judul Halaman -->
    <h2 class="font-semibold text-xl text-gray-800 my-4 leading-tight uppercase tracking-wide">
        Kasir & Manajemen Pembayaran
    </h2>

    <!-- Grid Utama Kasir -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM KIRI: Input & Pemilihan (Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- 1. Identifikasi Pelanggan -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200" x-data="{ mode: 'ots' }">
                <h3 class="text-lg font-bold text-gray-800 mb-4">1. Identitas Pelanggan</h3>
                
                <!-- Toggle Mode Button -->
                <div class="flex p-1 bg-gray-100 rounded-lg w-fit mb-4">
                    <button @click="mode = 'ots'" :class="mode === 'ots' ? 'bg-white shadow text-orange-600' : 'text-gray-500'" class="px-4 py-2 rounded-md text-sm font-medium transition cursor-pointer">On The Spot (OTS)</button>
                    <button @click="mode = 'booking'" :class="mode === 'booking' ? 'bg-white shadow text-orange-600' : 'text-gray-500'" class="px-4 py-2 rounded-md text-sm font-medium transition cursor-pointer">Cari Booking</button>
                </div>

                <!-- Form OTS -->
                <div x-show="mode === 'ots'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" placeholder="Nama Pelanggan" class="rounded-lg border-gray-300 text-gray-900 focus:ring-orange-500 focus:border-orange-500 p-3 bg-white">
                    <input type="text" placeholder="No. WhatsApp (62812...)" class="rounded-lg border-gray-300 text-gray-900 focus:ring-orange-500 focus:border-orange-500 p-3 bg-white">
                </div>

                <!-- Form Cari Booking -->
                <div x-show="mode === 'booking'" class="flex space-x-2">
                    <input type="text" placeholder="Masukkan Kode Booking atau Nama..." class="flex-1 rounded-lg border-gray-300 text-gray-900 bg-white p-3">
                    <button class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors cursor-pointer">Cari</button>
                </div>
            </div>

            <!-- Section 2: Penugasan Staff -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">2. Kru yang Bertugas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fotografer</label>
                        <select class="w-full rounded-lg border-gray-300 text-gray-900 bg-white p-3 cursor-pointer">
                            <option>Pilih Fotografer</option>
                            <option>Andika Pratama</option>
                            <option>Siti Rahma</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kasir / Editor</label>
                        <select class="w-full rounded-lg border-gray-300 text-gray-900 bg-white p-3 cursor-pointer">
                            <option>Pilih Editor</option>
                            <option>Budi Santoso</option>
                            <option>Self-Edit (Pelanggan)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3: Pilih Paket -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">3. Pilih Paket Foto</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Card Paket Aktif -->
                    <button class="p-4 border-2 border-orange-500 bg-orange-50 rounded-xl text-left transition transform hover:scale-[1.01] cursor-pointer">
                        <p class="font-bold text-orange-600">Personal Pro</p>
                        <p class="text-xs text-gray-500">1 Orang • 15 Menit</p>
                        <p class="mt-2 font-bold text-gray-800">Rp 150.000</p>
                    </button>
                    
                    <!-- Card Paket Non-Aktif -->
                    <button class="p-4 border border-gray-200 hover:border-orange-500 rounded-xl text-left transition transform hover:scale-[1.01] text-gray-700 bg-white cursor-pointer">
                        <p class="font-bold">Group Session</p>
                        <p class="text-xs text-gray-500">Up to 5 Orang • 30 Menit</p>
                        <p class="mt-2 font-bold">Rp 350.000</p>
                    </button>

                    <button class="p-4 border border-gray-200 hover:border-orange-500 rounded-xl text-left transition transform hover:scale-[1.01] text-gray-700 bg-white cursor-pointer">
                        <p class="font-bold">Graduation</p>
                        <p class="text-xs text-gray-500">Keluarga • 45 Menit</p>
                        <p class="mt-2 font-bold">Rp 500.000</p>
                    </button>
                </div>
            </div>

            <!-- Section 4: Add-ons -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">4. Tambahan (Add-ons)</h3>
                <div class="flex flex-wrap gap-3">
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 select-none bg-white">
                        <input type="checkbox" class="text-orange-500 bg-white border-gray-300 rounded focus:ring-orange-500">
                        <span class="text-sm font-medium text-gray-700">Extra Orang (+Rp 25rb)</span>
                    </label>
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 select-none bg-white">
                        <input type="checkbox" class="text-orange-500 bg-white border-gray-300 rounded focus:ring-orange-500">
                        <span class="text-sm font-medium text-gray-700">Extra Print (+Rp 15rb)</span>
                    </label>
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 select-none bg-white">
                        <input type="checkbox" class="text-orange-500 bg-white border-gray-300 rounded focus:ring-orange-500">
                        <span class="text-sm font-medium text-gray-700">Semua File (Softcopy) (+Rp 50rb)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Ringkasan & Pembayaran -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
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
                    <div class="flex justify-between text-sm text-green-600 font-medium bg-green-50 p-2 rounded-lg">
                        <span>DP / Deposit (Booking)</span>
                        <span>- Rp 50.000</span>
                    </div>
                </div>

                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-800">Rp 180.000</span>
                    </div>
                    <div class="flex justify-between items-center mt-2 bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm font-bold text-gray-600">Total Akhir</span>
                        <span class="text-2xl font-black text-orange-600">Rp 130.000</span>
                    </div>
                </div>

                <!-- Metode Pembayaran & Tombol Eksekusi -->
                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Metode Pembayaran</label>
                        <select class="w-full rounded-lg border-gray-300 text-gray-900 bg-white p-3 cursor-pointer">
                            <option>Cash</option>
                            <option>QRIS</option>
                            <option>Transfer Bank</option>
                        </select>
                    </div>
                    
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-orange-200 cursor-pointer text-center">
                        Selesaikan Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection