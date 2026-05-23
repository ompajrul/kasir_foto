@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-2">
        <h2 class="font-semibold text-xl text-gray-800 my-4 leading-tight uppercase tracking-wider">
            Tambah Booking Coser Baru
        </h2>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Instagram Pelanggan</label>
                            <input type="text" name="instagram"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                required>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Paket Utama (Pilih
                                    Satu)</label>
                                <div
                                    class="space-y-2 max-h-48 overflow-y-auto border-2 border-gray-200 rounded-lg p-3 bg-gray-50">
                                    @foreach($items->where('jenis', 'paket') as $item)
                                        <label
                                            class="flex items-center p-2 bg-white rounded-md border border-gray-200 hover:border-orange-500 cursor-pointer transition">
                                            {{-- name="id_item" tetap sama agar controller tidak bingung --}}
                                            <input type="radio" name="id_item" value="{{ $item->id }}"
                                                class="text-orange-500 focus:ring-orange-500 h-4 w-4 border-gray-300" required>
                                            <div class="ml-3 flex justify-between w-full text-sm">
                                                <span class="font-medium text-gray-900">{{ $item->nama_item }}</span>
                                                <span class="text-orange-600 font-bold">Rp
                                                    {{ number_format($item->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Add-on / Tambahan (Bisa Pilih
                                    Banyak)</label>
                                <div
                                    class="space-y-2 max-h-48 overflow-y-auto border-2 border-gray-200 rounded-lg p-3 bg-gray-50">
                                    @forelse($items->where('jenis', 'add_on') as $addon)
                                        <label
                                            class="flex items-center p-2 bg-white rounded-md border border-gray-200 hover:border-orange-500 cursor-pointer transition">
                                            {{-- Menggunakan array name="addons[]" karena bisa dikirim banyak --}}
                                            <input type="checkbox" name="addons[]" value="{{ $addon->id }}"
                                                class="text-orange-500 focus:ring-orange-500 h-4 w-4 rounded border-gray-300">
                                            <div class="ml-3 flex justify-between w-full text-sm">
                                                <span class="font-medium text-gray-900">{{ $addon->nama_item }}</span>
                                                <span class="text-emerald-600 font-bold">+ Rp
                                                    {{ number_format($addon->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-xs text-gray-400 italic p-2">Belum ada data Add-on yang tersedia.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">PIC (Staf Penanggung Jawab)</label>
                            <select name="pic"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Booking</label>
                                <input type="date" name="tanggal_booking"
                                    class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jam</label>
                                <input type="time" name="jam"
                                    class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kostum</label>
                            <input type="text" name="kostum"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none"
                                placeholder="Contoh: Genshin Impact - Hutao">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Status Awal</label>
                            <select name="status"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Note (Catatan Tambahan)</label>
                            <textarea name="note" rows="2"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3 border-t border-gray-100 pt-4">
                    <a href="{{ route('booking.index') }}"
                        class="px-5 py-2.5 text-gray-500 font-bold hover:text-gray-700 transition mt-1">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-2.5 rounded-lg shadow-lg shadow-orange-100 transition">
                        Simpan Pesanan
                    </button>
                </div>
            </form>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-6 rounded-r-lg shadow-sm" role="alert">
                <p class="font-bold">Ada masalah pada input kamu:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection