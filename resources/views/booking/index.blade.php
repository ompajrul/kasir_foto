@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        DATA BOOKING COSER
    </h2>
@endsection

@section('content')

    <h2 class="font-semibold text-xl text-gray-800 my-3 leading-tight uppercase tracking-wider">
        DATA BOOKING COSER
    </h2>

    <a @click="openModal = true; editMode = false; itemData = { jenis: 'paket' }"
        href="{{ route('booking.create') }}"" class=" bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg
        font-bold transition shadow-lg shadow-orange-200">
        + Tambah Item
    </a>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal & Jam</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instagram</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket (Item)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PIC</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-bold">{{ $booking->tanggal_booking }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->jam }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                        @<a href="https://instagram.com/{{ $booking->instagram }}" target="_blank">{{ $booking->instagram }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{-- Mengambil nama item dari relasi detail --}}
                        @foreach($booking->details as $detail)
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $detail->item->nama_item }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $booking->staf->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $booking->status_order == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($booking->status_order) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                        <a href="{{ route('booking.edit', $booking->id) }}"
                            class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        <form action="{{ route('booking.destroy', $booking->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection