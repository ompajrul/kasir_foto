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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('instagram')->nullable();
            $table->time('jam');
            $table->string('kostum')->nullable();
            $table->string('status_order')->default('pending'); // pending, confirmed, selesai, canceled
            $table->foreignId('pic')->constrained('users')->onDelete('cascade'); // Fotografer
            $table->date('tanggal_booking');
            $table->text('note')->nullable();
            $table->softDeletes(); // Safety feature
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
