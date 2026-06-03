<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib diubah ke true
    }

    public function rules(): array
    {
        return [
            'instagram'       => 'nullable',
            'kostum'          => 'nullable',
            'tanggal_booking' => 'required|date',
            'jam'             => 'required',
            'id_item'         => 'required|exists:items,id', 
            'pic'             => 'required',                 
            'addons'          => 'nullable|array',           
            'addons.*'        => 'exists:items,id',
        ];
    }
}