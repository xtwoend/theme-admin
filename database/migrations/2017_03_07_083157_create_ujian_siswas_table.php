<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUjianSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_siswas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('ujian_id')->unsigned();
            $table->string('ip')->nullable();
            $table->text('soals')->nullable();
            $table->tinyInteger('status')->default(0); // 0 Belum mulai, 1 Sedang mengerjakan, 2 Selesai mengerjakan, 3 Sudah di proses
            $table->datetime('last_submit')->nullable();
            $table->integer('lose_time')->default(0);
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
        Schema::dropIfExists('ujian_siswas');
    }
}
