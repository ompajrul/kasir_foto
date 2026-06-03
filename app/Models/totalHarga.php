<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Details;
class totalHarga extends Model
{
    public function totalHarga()
    {
        return $this->details->sum('harga_satuan');
    }
}
