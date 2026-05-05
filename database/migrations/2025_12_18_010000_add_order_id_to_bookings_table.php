<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('id')->unique();
        });
    }

    public function down()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
