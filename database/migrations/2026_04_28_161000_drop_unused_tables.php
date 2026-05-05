<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel ratings (fitur dihapus sesuai arahan dosen)
        Schema::dropIfExists('ratings');

        // Hapus tabel queue (fitur antrian tidak digunakan)
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');

        // Hapus tabel cache database (cache tidak digunakan via database)
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }

    public function down(): void
    {
        // Tidak perlu rollback untuk tabel yang memang tidak dipakai
    }
};
