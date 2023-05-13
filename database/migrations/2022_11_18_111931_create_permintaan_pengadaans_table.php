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
        Schema::create('permintaan_pengadaan', function (Blueprint $table) {
            $table->id('permintaan_pengadaan_id');
            $table->unsignedBigInteger('instansi_id');
            $table->unsignedBigInteger('sub_instansi_id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('sub_kegiatan_id');
            $table->unsignedBigInteger('rekening_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('paket_pengadaan_id');
            $table->text('spesifikasi_teknis_lainnya')->nullable()->default(null);
            $table->dateTime('waktu_pelaksanaan')->nullable()->default(null);
            $table->dateTime('waktu_barang_diterima')->nullable()->default(null);
            $table->string('lokasi_barang',200);
            $table->string('informasi_lainnya')->nullable()->default(null);
            $table->string('npwp_instansi', 255);
            $table->text('kualifikasi_kinerja')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('instansi_id')->references('instansi_id')->on('instansi');
            $table->foreign('sub_instansi_id')->references('sub_instansi_id')->on('sub_instansi');
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('kegiatan');
            $table->foreign('sub_kegiatan_id')->references('sub_kegiatan_id')->on('sub_kegiatan');
            $table->foreign('rekening_id')->references('rekening_id')->on('rekening');
            $table->foreign('program_id')->references('program_id')->on('program');
            $table->foreign('produk_id')->references('produk_id')->on('produk');
            $table->foreign('paket_pengadaan_id')->references('paket_pengadaan_id')->on('paket_pengadaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_pengadaan');
    }
};
