<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProsesBayarRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'id_order'          => 'required|exists:orders,id',
            'terbayarkan'       => 'required|numeric',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'pic_eksekutor'     => 'required|exists:users,id',
        ];
    }
}