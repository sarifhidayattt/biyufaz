<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. BCA, QRIS, Dana
            $table->string('account_number'); // e.g. 1234567890
            $table->string('account_name'); // e.g. PT Biyufaz
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
