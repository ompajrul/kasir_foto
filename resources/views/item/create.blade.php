
<form action="{{ route('item.store') }}" method="POST" x-data="{ jenis: 'paket' }">
    @csrf @method('POST')
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Nama Item</label>
            <input type="text" name="nama_item" class="w-full rounded-md border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Jenis</label>
            <select name="jenis" x-model="jenis" class="w-full rounded-md border-gray-300">
                <option value="paket">Paket</option>
                <option value="add_on">Add-on</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Harga</label>
            <input type="number" name="harga" class="w-full rounded-md border-gray-300" required>
        </div>

        <!-- Input jumlah_foto hanya muncul jika pilih Paket -->
        <div x-show="jenis === 'paket'">
            <label class="block text-sm font-medium">Jumlah Fotomi</label>
            <input type="number" name="jumlah_foto" class="w-full rounded-md border-gray-300">
        </div>

        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md">
            Simpan Item
        </button>
    </div>
</form>
