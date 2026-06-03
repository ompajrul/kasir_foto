<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Transaksi;
use App\Models\Item;
use App\Models\Details;
use Exception;

class TransaksiService
{
    /**
     * Memproses pembayaran dari antrean booking yang sudah ada
     */
    public function bayarBooking(array $data): array
    {
        $order = Orders::with('details')->findOrFail($data['id_order']);
        $totalBiaya = $order->details->sum('harga_satuan');

        if ($data['terbayarkan'] < $totalBiaya) {
            throw new Exception('Uang yang dibayarkan kurang dari total biaya!');
        }

        $idInvoice = 'INV-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);

        Transaksi::create([
            'id_order'          => $order->id,
            'id_invoice'        => $idInvoice,
            'total_biaya'       => $totalBiaya,
            'terbayarkan'       => $data['terbayarkan'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'tipe'              => 'booking',
            'kasir'             => auth()->id() ?? 1,
            'pic_eksekutor'     => $data['pic_eksekutor'],
        ]);

        $order->update(['status_order' => 'confirmed']);

        return [
            'invoice'   => $idInvoice,
            'kembalian' => $data['terbayarkan'] - $totalBiaya
        ];
    }

    /**
     * Memproses pembuatan order pintas sekaligus pembayaran langsung klien OTS
     */
    public function bayarOts(array $data): array
    {
        // 1. Hitung total belanjaan item OTS
        $totalBiaya = 0;
        foreach ($data['id_items_ots'] as $itemId) {
            $item = Item::findOrFail($itemId);
            $totalBiaya += $item->harga;
        }

        if ($data['terbayarkan'] < $totalBiaya) {
            throw new Exception('Uang yang dibayarkan kurang!');
        }

        // 2. Buat data order jangkar otomatis
        $orderOts = Orders::create([
            'instagram'       => $data['instagram_ots'],
            'jam'             => date('H:i'),
            'kostum'          => 'Pelanggan Langsung (OTS)',
            'status_order'    => 'confirmed',
            'pic'             => auth()->id() ?? 1,
            'tanggal_booking' => date('Y-m-d'),
            'note'            => 'Transaksi Kasir On The Spot'
        ]);

        $idInvoice = 'INV-OTS-' . date('Ymd') . '-' . rand(1000, 9999);

        // 3. Catat lembar Transaksi
        Transaksi::create([
            'id_order'          => $orderOts->id,
            'id_invoice'        => $idInvoice,
            'total_biaya'       => $totalBiaya,
            'terbayarkan'       => $data['terbayarkan'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'tipe'              => 'ots',
            'kasir'             => auth()->id() ?? 1,
            'pic_eksekutor'     => $data['pic_eksekutor'],
        ]);

        // 4. Hubungkan item belanjaan ke tabel rincian details
        foreach ($data['id_items_ots'] as $itemId) {
            $addonItem = Item::findOrFail($itemId);
            Details::create([
                'id_order'     => $orderOts->id,
                'id_item'      => $addonItem->id,
                'harga_satuan' => $addonItem->harga,
            ]);
        }

        return [
            'instagram' => $data['instagram_ots'],
            'kembalian' => $data['terbayarkan'] - $totalBiaya
        ];
    }
}