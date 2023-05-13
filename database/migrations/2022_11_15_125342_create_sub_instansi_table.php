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
        Schema::create('sub_instansi', function (Blueprint $table) {
            $table->id('sub_instansi_id');
            $table->unsignedBigInteger('instansi_id');
            $table->string('kode_sub_instansi',30);
            $table->string('nama_sub_instansi',150);
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
        Schema::dropIfExists('sub_instansi');
    }
};
