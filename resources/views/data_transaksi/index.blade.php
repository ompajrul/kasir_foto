@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-2">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-wider">
                Laporan Transaksi Hoshigraph
            </h2>
            <p class="text-sm text-gray-500 mt-1">Histori pembayaran dan pendapatan studio kasir.</p>
            <button onclick="exportToExcel()" class="mt-3 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-md">
                📊 Export ke Excel
            </button>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-3 rounded-xl shadow-lg text-right">
            <span class="text-xs uppercase font-bold tracking-wider opacity-80">Total Pendapatan (Omset)</span>
            <div class="text-xl font-black">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tabel-transaksi" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="p-4">ID / Tanggal</th>
                        <th class="p-4">Instagram Pelanggan</th>
                        <th class="p-4">Rincian Pembelian (Item)</th>
                        <th class="p-4">PIC booking/kasir</th>
                        <th class="p-4">PIC foto(eksekusi)</th>
                        <th class="p-4">Total Bayar</th>
                        <th class="p-4 text-center">Status pembayaran</th>
                        <th class="p-4 text-center">Status foto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-bold text-gray-800">#TRX-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($transaksi->tanggal_booking)->format('d M Y') }}</div>
                            </td>
                            
                            <td class="p-4 font-semibold text-blue-600">
                                @<a href="https://instagram.com/{{ $transaksi->instagram }}" target="_blank" class="hover:underline">{{ $transaksi->instagram }}</a>
                                @if($transaksi->kostum)
                                    <div class="text-xs text-gray-500 font-normal mt-1 italic">Cos: {{ $transaksi->kostum }}</div>
                                @endif
                            </td>
                            
                            <td class="p-4 space-y-1">
                                @foreach($transaksi->details as $detail)
                                    <div class="flex items-center text-xs">
                                        <span class="px-2 py-0.5 rounded font-bold mr-2 {{ $detail->item->jenis == 'paket' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                            {{ $detail->item->jenis == 'paket' ? 'Paket' : 'Addon' }}
                                        </span>
                                        <span class="text-gray-700 font-medium">{{ $detail->item->nama_item }}</span>
                                    </div>
                                @endforeach
                            </td>
                            
                            <td class="p-4 text-gray-600 font-medium">
                                {{ $transaksi->staf->name ?? 'N/A' }}
                            </td>

                            <td class="p-4 text-gray-800 font-semibold">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">
                                    📸 {{ $transaksi->transaksi->eksekutor->name ?? 'Belum Di-handle' }}
                                </span>
                            </td>
                            
                            <td class="p-4 font-bold text-gray-900 text-base">
                                Rp {{ number_format($transaksi->totalHarga(), 0, ',', '.') }}
                            </td>
                            
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $transaksi->status_order == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ strtoupper($transaksi->status_order) }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                @if($transaksi->transaksi)
                                    <form action="{{ route('transaksi.update_status_pelaksanaan', $transaksi->transaksi->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <select name="status_pelaksanaan" onchange="this.form.submit()" 
                                            class="text-xs font-bold px-2.5 py-1.5 rounded-lg border outline-none cursor-pointer transition
                                            {{ $transaksi->transaksi->status_pelaksanaan === 'completed' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                            {{ $transaksi->transaksi->status_pelaksanaan === 'processing' ? 'bg-amber-50 text-amber-700 border-amber-200 animate-pulse' : '' }}
                                            {{ $transaksi->transaksi->status_pelaksanaan === 'waiting' ? 'bg-gray-50 text-gray-600 border-gray-200' : '' }}">
                                            
                                            <option value="waiting" {{ $transaksi->transaksi->status_pelaksanaan === 'waiting' ? 'selected' : '' }}>⏳ Waiting</option>
                                            <option value="processing" {{ $transaksi->transaksi->status_pelaksanaan === 'processing' ? 'selected' : '' }}>📸 Processing</option>
                                            <option value="completed" {{ $transaksi->transaksi->status_pelaksanaan === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum Ada Transaksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center text-gray-400 italic bg-gray-50">Belum ada histori transaksi masuk...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script>
function exportToExcel() {
    let table = document.getElementById('tabel-transaksi');
    if (!table) {
        alert('Tabel transaksi tidak ditemukan!');
        return;
    }

    let clonedTable = table.cloneNode(true);
    let tableHTML = clonedTable.outerHTML;

    let excelTemplate = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="UTF-8">
            <style>
                table { border-collapse: collapse; width: 100%; }
                th { background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px; }
                td { border: 1px solid #e5e7eb; padding: 8px; }
            </style>
        </head>
        <body>
            ${tableHTML}
        </body>
        </html>
    `;

    let blob = new Blob(['\ufeff' + excelTemplate], {
        type: 'application/vnd.ms-excel;charset=utf-8;'
    });

    let filename = 'Laporan_Transaksi_Hoshigraph_' + new Date().toISOString().slice(0,10) + '.xls';

    if (navigator.msSaveOrOpenBlob) {
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        let link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>