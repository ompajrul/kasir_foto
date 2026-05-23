<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;
    // use SoftDeletes; 

    // Mendefinisikan kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_item',
        'jenis',
        'harga',
        'jumlah_foto',
    ];

    /**
     * Casting tipe data agar harga selalu keluar sebagai angka (bukan string)
     */
    protected $casts = [
        'harga' => 'double',
        'jumlah_foto' => 'integer',
    ];

    /**
     * Relasi ke tabel Detail
     * Satu item bisa muncul di banyak detail transaksi (History)
     */
    public function details()
    {
        return $this->hasMany(Detail::class, 'id_item');
    }
}
