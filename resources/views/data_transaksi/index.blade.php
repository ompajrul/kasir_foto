@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        DATA TRANSAKSI
    </h2>
@endsection

@section('content')
   <h2 class="font-semibold text-xl text-gray-800 my-3 leading-tight">
        DATA TRANSAKSI
    </h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-bold">List Antrean</h3>
            {{-- <a href="{{ route('booking.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded"> --}}
            <a href="#" class="bg-orange-500 text-white px-4 py-2 rounded">
                + Tambah
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b text-left text-gray-600">
                   
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-3 italic text-gray-400" colspan="3">Data kosong...</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection