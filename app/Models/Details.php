<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;
    protected $table = 'details';
    protected $fillable = [
        'id_order',
        'id_item',
        'harga_satuan',
        'qty',

    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id_order');
    }

    /**
     * Relasi ke Item (Paket)
     */
    public function item() {
    return $this->belongsTo(Item::class, 'id_item');
}
}
