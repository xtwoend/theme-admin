<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mapel_id')->unsigned();
            $table->text('pertanyaan')->nullable();
            $table->text('opsi')->nullable();
            $table->integer('kunci')->nullable();
            $table->string('audio')->nullable();
            $table->tinyInteger('type')->default(0); // 0 PG, 1 Essay
            $table->integer('kategori')->default(0); // 0 mudah, 1 sedang, 2 sulit
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
        Schema::dropIfExists('soals');
    }
}
