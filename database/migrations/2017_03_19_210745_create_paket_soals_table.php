<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaketSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_soals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mapel_id')->unsigned();
            $table->string('nama');
            $table->text('soal')->nullable();
            $table->integer('jumlah_soal')->unsigned();
            $table->integer('soal_pg')->unsigned()->default(0); 
            $table->integer('soal_essay')->unsigned()->default(0);
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('paket_soals');
    }
}
