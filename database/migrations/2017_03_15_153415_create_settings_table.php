<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_sekolah')->nullable();
            $table->string('status_sekolah')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telp')->nullable();
            $table->integer('jumlah_ruang')->default(0);
            $table->integer('jumlah_unit')->default(0);
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
