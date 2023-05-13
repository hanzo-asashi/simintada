<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_pengadaan', function (Blueprint $table) {
            $table->id('paket_pengadaan_id');
            $table->string('nama_paket_pengadaan', 255);
            $table->string('kode_rup', 30);
            $table->unsignedDouble('pagu')->nullable()->default(0);
            $table->unsignedDouble('hps')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_pengadaan');
    }
};
