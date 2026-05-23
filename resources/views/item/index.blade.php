@extends('layouts.app')

@section('content')
<div x-data="{ 
    openModal: {{ $errors->any() ? 'true' : 'false' }}, 
    editMode: false, 
    itemData: { 
        id: '', 
        nama_item: '', 
        jenis: 'paket', 
        harga: '', 
        jumlah_foto: '' 
    } 
}">
    <h2 class="font-semibold text-xl text-gray-800 my-3 leading-tight uppercase tracking-wider">
        Manajemen Item Hoshigraph
    </h2>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-700">Daftar Paket & Add-on</h3>
                <p class="text-sm text-gray-500">Kelola harga dan layanan studio kamu di sini.</p>
            </div>
            <button @click="openModal = true; editMode = false; itemData = { jenis: 'paket' }" 
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-bold transition shadow-lg shadow-orange-200">
                + Tambah Item
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b">
                        <th class="p-4">Nama Item</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Jml Foto</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium text-gray-800">{{ $item->nama_item }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $item->jenis == 'paket' ? 'bg-blue-100 text-blue-600' : 'bg-emerald-100 text-emerald-600' }}">
                                    {{ strtoupper($item->jenis) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="p-4 text-gray-600">{{ $item->jumlah_foto ?? '-' }}</td>
                            <td class="p-4 flex justify-center space-x-2">
                                <button @click="openModal = true; editMode = true; itemData = {{ json_encode($item) }}" 
                                        class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                
                                <form action="{{ route('item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus item ini?')">
                                    @csrf 
                                    <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 italic">Belum ada data item...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800" x-text="editMode ? 'Edit Item' : 'Tambah Item Baru'"></h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="editMode ? `/item/${itemData.id}` : '{{ route('item.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Item</label>
                            <input type="text" name="nama_item" x-model="itemData.nama_item" class="w-full rounded-lg border-gray-300 focus:ring-orange-500" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis</label>
                                <select name="jenis" x-model="itemData.jenis" class="w-full rounded-lg border-gray-300">
                                    <option value="paket">Paket</option>
                                    <option value="add_on">Add-on</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga (Rp)</label>
                                <input type="number" name="harga" x-model="itemData.harga" class="w-full rounded-lg border-gray-300" required>
                            </div>
                        </div>

                        <div x-show="itemData.jenis === 'paket'">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah Foto</label>
                            <input type="number" name="jumlah_foto" x-model="itemData.jumlah_foto" class="w-full rounded-lg border-gray-300">
                            <p class="mt-1 text-[10px] text-gray-400 italic">*Kosongkan jika tidak ada batas foto</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="openModal = false" class="px-4 py-2 text-gray-500 font-bold hover:text-gray-700 transition">Batal</button>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2 rounded-lg font-bold shadow-lg shadow-orange-200 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection