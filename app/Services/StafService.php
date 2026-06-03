<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StafService
{
    /**
     * Memproses pendaftaran anggota staf baru ke database Hoshigraph
     * beserta enkripsi password-nya.
     */
    public function registerStaf(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']), // Otomatis mengamankan password sebelum masuk DB
            'role'     => $data['role'],
        ]);
    }
}