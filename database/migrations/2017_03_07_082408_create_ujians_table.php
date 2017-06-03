<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('mapel_id')->unsigned();
            $table->integer('paket_soal_id')->unsigned();
            $table->integer('jumlah_soal')->unsigned();
            $table->integer('soal_pg')->unsigned()->default(0); 
            $table->integer('soal_essay')->unsigned()->default(0);
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_berakhir')->nullable();
            $table->integer('lama_waktu')->unsigned()->default(0); // dalam menit
            $table->integer('batas_terlambat')->unsigned()->default(0); // dalam menit
            $table->tinyInteger('status')->default(0); // 0 belum mulai, 1 sedang berlangsung, 2 sudah berakhir
            $table->tinyInteger('soal_acak')->default(0);
            $table->tinyInteger('opsi_acak')->default(0);
            $table->string('token')->nullable();
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
        Schema::dropIfExists('ujians');
    }
}
