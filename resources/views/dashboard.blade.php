{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Ringkasan') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
            <div class="text-sm font-medium text-gray-500">Total Booking</div>
            <div class="text-2xl font-bold mt-1">15</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
            <div class="text-sm font-medium text-gray-500">Sedang Diedit</div>
            <div class="text-2xl font-bold mt-1 text-blue-600">8</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500">Selesai/Sent</div>
            <div class="text-2xl font-bold mt-1 text-green-600">7</div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-xl shadow-sm">
        <h3 class="text-lg font-bold mb-4">Pesanan Terbaru</h3>
        <p class="text-gray-400 italic">Belum ada aktivitas terbaru...</p>
    </div>
</x-app-layout> --}}

@extends('layouts.app')
@section('content')

   <h1 class="font-semibold text-xl text-gray-800 my-3 leading-tight">
        DASHBOARD
    </h1>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
            <div class="text-sm font-medium text-gray-500">Total Booking</div>
            <div class="text-2xl font-bold mt-1">15</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
            <div class="text-sm font-medium text-gray-500">Sedang Diedit</div>
            <div class="text-2xl font-bold mt-1 text-blue-600">8</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500">Selesai/Sent</div>
            <div class="text-2xl font-bold mt-1 text-green-600">7</div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-xl shadow-sm">
        <h3 class="text-lg font-bold mb-4">Pesanan Terbaru</h3>
        <p class="text-gray-400 italic">Belum ada aktivitas terbaru...</p>
    </div>
    @endsection