<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_item',
        'status_order',
        'instagram',
        'tanggal_booking', // Kamu sebut tanggal_booking, saya sesuaikan ke tgl_foto agar konsisten dengan sebelumnya
        'jam',
        'kostum',
        'status',
        'pic',
        'note'
    ];

    /**
     * Casting tipe data agar Carbon bisa mengolah tanggal secara otomatis
     */
    protected $casts = [
        'tanggal_foto' => 'date',
        // jam_foto tetap string biasanya sudah cukup untuk input type="time"
    ];

    /**
     * Relasi Balik ke Model Item
     * Setiap booking pasti merujuk ke satu Paket/Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function staf()
    {
        return $this->belongsTo(User::class, 'pic');
    }

    public function details()
    {
        return $this->hasMany(Details::class, 'id_order');
    }
}