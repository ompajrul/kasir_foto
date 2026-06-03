<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStafRequest extends FormRequest
{
    /**
     * Tentukan apakah user diperbolehkan melakukan request ini.
     */
    public function authorize(): bool
    {
        // WAJIB diubah menjadi true agar request tidak ditolak otomatis oleh Laravel
        return true; 
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' memastikan password cocok dengan field password_confirmation
            'role'     => 'required|in:super_admin,staf',
        ];
    }

    /**
     * Kustomisasi pesan error (Opsional, agar bahasanya lebih rapi di Bootstrap).
     */
    public function messages(): array
    {
        return [
            'email.unique'       => 'Alamat email ini sudah terdaftar di sistem Hoshigraph!',
            'password.confirmed' => 'Konfirmasi password tidak cocok, silakan periksa kembali.',
            'password.min'       => 'Password staf baru minimal harus 8 karakter.',
            'role.in'            => 'Role yang dipilih tidak valid!',
        ];
    }
}