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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id')->nullable();
            $table->foreignId('gaji_pegawai_id')->nullable();
            $table->string('nama_pegawai');
            $table->integer('total_gaji')->nullable();
            $table->decimal('pajak', 5, 2)->nullable();
            $table->integer('gaji_bersih')->nullable();
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
        Schema::dropIfExists('pegawais');
    }
};
