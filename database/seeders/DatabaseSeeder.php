<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jika email ini belum ada di DB, Laravel akan otomatis membuatnya langsung jadi Super Admin
        User::firstOrCreate(
            ['email' => 'admin@hoshigraph.com'], 
            [
                'name'     => 'Admin Besar',
                'password' => Hash::make('AdminBesar123'), // Silakan ganti password-mu
                'role'     => 'super_admin',            // Akun utama pemegang kendali
            ]
        );
    }
}