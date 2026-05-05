<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('venue_id')->constrained('lapangan')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->date('booking_date');
            $table->json('time_slots'); 
            $table->decimal('total_price', 10, 0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
