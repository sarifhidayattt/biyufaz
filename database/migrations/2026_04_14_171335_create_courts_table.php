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
        Schema::create('detail_lapangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained('lapangan')->onDelete('cascade');
            $table->string('name'); // e.g. Lapangan A, Lapangan B
            $table->string('type')->nullable(); // e.g. Rumput Sintetis, Vinyl
            $table->integer('price')->nullable(); // overrides venue base price if needed
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_lapangan');
    }
};
