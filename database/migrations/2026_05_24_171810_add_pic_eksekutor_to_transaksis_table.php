<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Kolom untuk mendata staf aktual di lapangan (hari-H)
            $table->unsignedBigInteger('pic_eksekutor')->nullable()->after('kasir');

            // Relasikan ke tabel users
            $table->foreign('pic_eksekutor')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pic_eksekutor']);
            $table->dropColumn('pic_eksekutor');
        });
    }
};
