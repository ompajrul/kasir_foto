<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('orders')->onDelete('cascade');
            $table->string('id_invoice')->unique();
            $table->decimal('total_biaya', 12, 2); // Nilai akhir setelah hitung item + add-on
            $table->decimal('terbayarkan', 12, 2); // Nominal yang masuk (termasuk DP jika ada)
            $table->string('metode_pembayaran'); // Cash, QRIS, Transfer
            $table->enum('tipe', ['booking', 'ots']);
            $table->foreignId('kasir')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
