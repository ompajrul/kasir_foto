@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-2" x-data="{
                    tab: 'booking', // Default tab kasir: booking
                    selectedOrderId: '',
                    terbayarkanBooking: 0,
                    terbayarkanOts: 0,

                    // Data List untuk OTS
                    selectedOtsItems: [], 
                    allItems: {{ json_encode($items->map(fn($i) => ['id' => $i->id, 'nama' => $i->nama_item, 'harga' => $i->harga, 'jenis' => $i->jenis])) }},

                    // Data List untuk Booking Antrean
                    orders: {{ json_encode($orders->map(function ($o) {
        return [
            'id' => $o->id,
            'instagram' => $o->instagram,
            'kostum' => $o->kostum,
            'total' => $o->details->sum('harga_satuan'),
            'item_list' => $o->details->map(fn($d) => $d->item->nama_item)->join(', ')
        ];
    })) }},

                    get selectedOrder() {
                        return this.orders.find(o => o.id == this.selectedOrderId) || null;
                    },
                    get totalOts() {
                        return this.selectedOtsItems.reduce((sum, itemId) => {
                            let item = this.allItems.find(i => i.id == itemId);
                            return sum + (item ? item.harga : 0);
                        }, 0);
                    },
                    get kembalian() {
                        if (this.tab === 'booking') {
                            if(!this.selectedOrder) return 0;
                            let sisa = this.terbayarkanBooking - this.selectedOrder.total;
                            return sisa > 0 ? sisa : 0;
                        } else {
                            let sisa = this.terbayarkanOts - this.totalOts;
                            return sisa > 0 ? sisa : 0;
                        }
                    }
                }">

        <div class="flex justify-between items-center my-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-wider">
                Kasir Hoshigraph <span class="text-xs bg-orange-100 text-orange-600 font-bold px-2 py-1 rounded ml-1"
                    x-text="tab.toUpperCase()"></span>
            </h2>
            <div class="bg-gray-200 p-1 rounded-lg flex space-x-1 shadow-inner">
                <button @click="tab = 'booking'; selectedOrderId = ''; terbayarkanBooking = 0"
                    :class="tab === 'booking' ? 'bg-orange-500 text-white shadow' : 'text-gray-600 hover:text-gray-900'"
                    class="px-4 py-1.5 rounded-md font-bold text-sm transition">
                    Antrean Booking
                </button>
                <button @click="tab = 'ots'; selectedOtsItems = []; terbayarkanOts = 0"
                    :class="tab === 'ots' ? 'bg-orange-500 text-white shadow' : 'text-gray-600 hover:text-gray-900'"
                    class="px-4 py-1.5 rounded-md font-bold text-sm transition">
                    Pelanggan OTS (Langsung)
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                <div x-show="tab === 'booking'">
                    <form action="{{ route('kasir.bayar') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Antrean Pelanggan
                                    (Instagram)</label>
                                <select name="id_order" x-model="selectedOrderId"
                                    class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2.5 focus:border-orange-500 outline-none">
                                    <option value="">-- Pilih Akun Coser --</option>
                                    <template x-for="order in orders" :key="order.id">
                                        <option :value="order.id"
                                            x-text="'@' + order.instagram + ' (' + order.item_list + ')'"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Metode Pembayaran</label>
                                    <select name="metode_pembayaran"
                                        class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                        <option value="cash">Uang Tunai (Cash)</option>
                                        <option value="transfer">Bank Transfer / QRIS</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Staf
                                        Lapangan (Handle Hari-H)</label>
                                    <select name="pic_eksekutor"
                                        class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition"
                                        required>
                                        <option value="" disabled selected>-- Pilih Fotografer / Staf Lapangan --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Uang yang Diterima
                                        (Rp)</label>
                                    <input type="number" name="terbayarkan" x-model.number="terbayarkanBooking"
                                        class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                </div>
                            </div>

                            <button type="submit"
                                :disabled="!selectedOrderId || terbayarkanBooking < (selectedOrder ? selectedOrder.total : 0)"
                                class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-200 disabled:cursor-not-allowed text-white font-bold py-3 rounded-lg mt-4 transition uppercase tracking-wider">
                                🛒 Proses Pembayaran Booking
                            </button>
                        </div>
                    </form>
                </div>

                <div x-show="tab === 'ots'" x-cloak>
                    <form action="{{ route('kasir.bayar_ots') }}" method="POST">
                        @csrf
                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Instagram / Nama Pelanggan
                                    OTS</label>
                                <input type="text" name="instagram_ots" placeholder="Contoh: @akin atau Pelanggan1"
                                    class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Layanan & Tambahan (Bisa
                                    Centang Banyak)</label>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto p-2 border border-gray-100 bg-gray-50 rounded-lg">
                                    <template x-for="item in allItems" :key="item.id">
                                        <label
                                            class="flex items-center p-2.5 bg-white rounded-md border border-gray-200 hover:border-orange-500 cursor-pointer transition select-none">
                                            <input type="checkbox" name="id_items_ots[]" :value="item.id"
                                                x-model="selectedOtsItems"
                                                class="text-orange-500 focus:ring-orange-500 h-4 w-4 rounded border-gray-300">
                                            <div class="ml-3 text-xs w-full">
                                                <div class="font-bold text-gray-900" x-text="item.nama"></div>
                                                <div class="text-orange-600 font-bold mt-0.5"
                                                    x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(item.harga)">
                                                </div>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Metode Pembayaran</label>
                                    <select name="metode_pembayaran"
                                        class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                        <option value="cash">Uang Tunai (Cash)</option>
                                        <option value="transfer">Bank Transfer / QRIS</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Uang yang Diterima
                                        (Rp)</label>
                                    <input type="number" name="terbayarkan" x-model.number="terbayarkanOts"
                                        class="w-full border-2 border-gray-300 text-black bg-white rounded-lg px-3 py-2 focus:border-orange-500 outline-none">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Staf
                                    Lapangan (Handle Hari-H)</label>
                                <select name="pic_eksekutor"
                                    class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition"
                                    required>
                                    <option value="" disabled selected>-- Pilih Fotografer / Staf Lapangan --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" :disabled="selectedOtsItems.length === 0 || terbayarkanOts < totalOts"
                                class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-200 disabled:cursor-not-allowed text-white font-bold py-3 rounded-lg mt-4 transition uppercase tracking-wider">
                                ⚡️ Proses Cetak Nota OTS
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="bg-gray-900 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <div>
                    <h3 class="text-xs uppercase tracking-widest text-orange-400 font-bold mb-4">Nota Pembayaran</h3>

                    <div x-show="tab === 'booking'" class="space-y-3 text-sm">
                        <template x-if="selectedOrder">
                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-gray-800 pb-2">
                                    <span class="text-gray-400">Tipe Pelanggan:</span>
                                    <span
                                        class="badge bg-blue-900 text-blue-200 text-[10px] px-2 py-0.5 rounded font-bold uppercase">Booking</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-800 pb-2">
                                    <span class="text-gray-400">Coser :</span>
                                    <span class="font-bold text-orange-300" x-text="'@' + selectedOrder.instagram"></span>
                                </div>
                                <div class="border-b border-gray-800 pb-2">
                                    <span class="text-gray-400 block mb-1">Layanan :</span>
                                    <span class="text-xs text-gray-300 italic" x-text="selectedOrder.item_list"></span>
                                </div>
                            </div>
                        </template>
                        <template x-if="!selectedOrderId">
                            <p class="text-xs text-gray-500 italic text-center py-10">Pilih antrean pesanan coser...</p>
                        </template>
                    </div>

                    <div x-show="tab === 'ots'" class="space-y-3 text-sm" x-cloak>
                        <div class="flex justify-between border-b border-gray-800 pb-2">
                            <span class="text-gray-400">Tipe Pelanggan:</span>
                            <span
                                class="badge bg-emerald-900 text-emerald-200 text-[10px] px-2 py-0.5 rounded font-bold uppercase">On
                                The Spot (OTS)</span>
                        </div>
                        <div class="border-b border-gray-800 pb-2">
                            <span class="text-gray-400 block mb-2">Item Terpilih:</span>
                            <div class="space-y-1.5 max-h-32 overflow-y-auto">
                                <template x-for="itemId in selectedOtsItems" :key="itemId">
                                    <div class="flex justify-between text-xs text-gray-300 bg-gray-800 p-1.5 rounded">
                                        <span x-text="allItems.find(i => i.id == itemId)?.nama"></span>
                                        <span class="font-bold text-white"
                                            x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(allItems.find(i => i.id == itemId)?.harga)"></span>
                                    </div>
                                </template>
                            </div>
                            <template x-if="selectedOtsItems.length === 0">
                                <p class="text-xs text-gray-600 italic text-center py-4">Belum ada item yang dipilih</p>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t-2 border-dashed border-gray-800 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-400">TOTAL TAGIHAN:</span>
                        <span class="text-xl font-black text-white"
                            x-text="tab === 'booking' ? (selectedOrder ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedOrder.total) : 'Rp 0') : 'Rp ' + new Intl.NumberFormat('id-ID').format(totalOts)"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-400">KEMBALIAN :</span>
                        <span class="text-xl font-black text-emerald-400"
                            x-text="selectedOtsItems.length > 0 || selectedOrderId ? 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian) : 'Rp 0'"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection