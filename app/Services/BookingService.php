<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Item;
use App\Models\Details;

class BookingService
{
    /**
     * Memproses pembuatan booking baru beserta detail itemnya
     */
    public function createBooking(array $data): Orders
    {
        $order = Orders::create([
            'instagram'       => $data['instagram'] ?? null,
            'jam'             => $data['jam'],
            'kostum'          => $data['kostum'] ?? null,
            'status_order'    => $data['status_order'] ?? 'pending',
            'pic'             => $data['pic'], 
            'tanggal_booking' => $data['tanggal_booking'],
            'note'            => $data['note'] ?? null,
        ]);

        $this->syncDetails($order->id, $data['id_item'], $data['addons'] ?? []);

        return $order;
    }

    /**
     * Memproses pembaruan data booking (Hapus rincian lama, masukkan yang baru)
     */
    public function updateBooking(int $id, array $data): Orders
    {
        $booking = Orders::findOrFail($id);

        $booking->update([
            'instagram'       => $data['instagram'],
            'tanggal_booking' => $data['tanggal_booking'],
            'jam'             => $data['jam'],
            'kostum'          => $data['kostum'] ?? null,
            'status_order'    => $data['status'], 
            'pic'             => $data['pic'],
            'note'            => $data['note'] ?? null,
        ]);

        // Bersihkan rincian lama
        Details::where('id_order', $booking->id)->delete();

        // Tulis ulang rincian baru
        $this->syncDetails($booking->id, $data['id_item'], $data['addons'] ?? []);

        return $booking;
    }

    /**
     * Fungsi privat pembantu untuk menulis relasi item ke tabel details
     */
    private function syncDetails(int $orderId, int $mainItemId, array $addonIds): void
    {
        // Masukkan Paket Utama
        $paketUtama = Item::findOrFail($mainItemId);
        Details::create([
            'id_order'     => $orderId,
            'id_item'      => $paketUtama->id,
            'harga_satuan' => $paketUtama->harga, 
        ]);

        // Masukkan Add-ons jika ada
        foreach ($addonIds as $addonId) {
            $addonItem = Item::findOrFail($addonId);
            Details::create([
                'id_order'     => $orderId,
                'id_item'      => $addonItem->id,
                'harga_satuan' => $addonItem->harga,
            ]);
        }
    }
}