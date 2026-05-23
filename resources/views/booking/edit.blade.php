@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-2">
    <h2 class="font-semibold text-xl text-gray-800 my-4 leading-tight uppercase tracking-wider">
        Edit Booking Coser
    </h2>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Wajib untuk proses Update di Laravel --}}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Instagram Pelanggan</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $booking->instagram) }}"
                            class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Paket</label>
                        <select name="id_item" class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $current_item_id ? 'selected' : '' }}>
                                    {{ $item->nama_item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">PIC (Staf Penanggung Jawab)</label>
                        <select name="pic" class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $booking->pic ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking', $booking->tanggal_booking) }}"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jam</label>
                            <input type="time" name="jam" value="{{ old('jam', \Carbon\Carbon::parse($booking->jam)->format('H:i')) }}"
                                class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kostum</label>
                        <input type="text" name="kostum" value="{{ old('kostum', $booking->kostum) }}"
                            class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                            <option value="pending" {{ $booking->status_order == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status_order == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Note (Catatan Tambahan)</label>
                        <textarea name="note" rows="2" class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">{{ old('note', $booking->note) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3 border-t border-gray-100 pt-4">
                <a href="{{ route('booking.index') }}" class="px-5 py-2.5 text-gray-500 font-bold hover:text-gray-700 transition mt-1">
                    Batal
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-2.5 rounded-lg shadow-lg shadow-orange-100 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection