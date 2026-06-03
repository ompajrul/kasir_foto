<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProsesBayarOtsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'instagram_ots'   => 'required|string|max:255',
            'id_items_ots'    => 'required|array',
            'id_items_ots.*'  => 'exists:items,id',
            'terbayarkan'     => 'required|numeric',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'pic_eksekutor'     => 'required|exists:users,id',
        ];
    }
}