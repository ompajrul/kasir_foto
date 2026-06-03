<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis'; // Sesuaikan nama tabel di phpMyAdmin kamu

    protected $fillable = [
        'id_order',
        'id_invoice',
        'total_biaya',
        'terbayarkan',
        'metode_pembayaran',
        'tipe',
        'kasir',
        'pic_eksekutor',
        'status_pelaksanaan' 
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id_order');
    }

    public function eksekutor()
    {
        return $this->belongsTo(User::class, 'pic_eksekutor');
    }
}