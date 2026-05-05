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
        Schema::table('slot_waktu', function (Blueprint $table) {
            $table->foreignId('court_id')->nullable()->after('venue_id')->constrained('detail_lapangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slot_waktu', function (Blueprint $table) {
            $table->dropForeign(['court_id']); 
            $table->dropColumn('court_id');
        });
    }
};
