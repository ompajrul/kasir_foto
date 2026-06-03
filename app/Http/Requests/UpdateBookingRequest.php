<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'instagram'       => 'required', // Saat update wajib diisi
            'kostum'          => 'nullable',
            'tanggal_booking' => 'required|date',
            'jam'             => 'required',
            'id_item'         => 'required|exists:items,id',
            'pic'             => 'required',
            'status'          => 'required',
            'addons'          => 'nullable|array',
            'addons.*'        => 'exists:items,id',
        ];
    }
}