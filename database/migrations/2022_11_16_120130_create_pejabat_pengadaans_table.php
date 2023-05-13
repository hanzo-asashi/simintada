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
    public function up(): void
    {
        Schema::create('pejabat_pengadaan', function (Blueprint $table) {
            $table->id('id_pejabat_pengadaan');
            $table->string('nama_pejabat_pengadaan')->nullable();
            $table->string('nip_pejabat_pengadaan')->nullable();
            $table->string('jabatan_pejabat_pengadaan')->nullable();
            $table->unsignedBigInteger('skpd_id')->nullable()->default(0);
            $table->unsignedBigInteger('role_id')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pejabat_pengadaan');
    }
};
