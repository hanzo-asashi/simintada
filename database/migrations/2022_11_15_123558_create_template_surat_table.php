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
        Schema::create('template_surat', function (Blueprint $table) {
            $table->id('id_template_surat');
            $table->unsignedBigInteger('instansi_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('rekening_id');
            $table->string('nama_surat', 255);
            $table->string('nomor_surat', 100);
            $table->string('lampiran', 255);
            $table->string('perihal', 255);
            $table->string('ditujukan_ke', 255);
            $table->string('tujuan', 255);
            $table->string('nama_penandatangan', 255);
            $table->string('nip_penandatangan', 255);
            $table->dateTime('tanggal_surat')->default(today());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_surat');
    }
};
