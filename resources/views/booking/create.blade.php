@extends('layouts.app')

@section('content')
    <form action="{{ route('booking.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700">instagram Pelanggan</label>
                    <input type="text" name="instagram" class="w-full rounded-lg border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Pilih Paket</label>
                    <select name="id_item" class="w-full rounded-lg border-gray-300">
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_item }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700">PIC (Staf Penanggung Jawab)</label>
                    <select name="pic" class="w-full rounded-lg border-gray-300">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Tanggal Booking</label>
                        <input type="date" name="tanggal_booking" class="w-full rounded-lg border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Jam</label>
                        <input type="time" name="jam" class="w-full rounded-lg border-gray-300" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700">Kostum</label>
                    <input type="text" name="kostum" class="w-full rounded-lg border-gray-300"
                        placeholder="">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700">Status Awal</label>
                    <select name="status" class="w-full rounded-lg border-gray-300">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700">Note (Catatan Tambahan)</label>
                    <textarea name="note" rows="1" class="w-full rounded-lg border-gray-300"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit"
                class="w-full bg-orange-500 text-white font-bold py-3 rounded-lg hover:bg-orange-600 transition">
                Simpan Pesanan
            </button>
        </div>
    </form>
    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm" role="alert">
        <p class="font-bold">Ada masalah pada input kamu:</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection