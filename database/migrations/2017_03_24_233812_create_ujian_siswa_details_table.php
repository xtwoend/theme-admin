<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUjianSiswaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_siswa_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ujian_siswa_id')->unsigned();
            $table->integer('soal_id')->unsigned();
            $table->integer('no_urut')->nullable();
            $table->integer('jawaban')->nullable();
            $table->text('jawaban_text')->nullable();
            $table->integer('kunci')->nullable();
            $table->integer('nilai')->nullable();
            $table->tinyInteger('status')->default(0); // 0 belum di jawab, 1 sudah di jawab, 2 ragu ragu, 3 sudah di koreksi
            $table->datetime('waktu_jawab')->nullable();
            $table->datetime('waktu_koreksi')->nullable();
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
        Schema::dropIfExists('ujian_siswa_details');
    }
}
