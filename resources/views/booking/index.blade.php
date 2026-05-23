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
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $booking->status_order == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($booking->status_order) }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <a href="#" class="text-orange-600 hover:text-orange-900">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection