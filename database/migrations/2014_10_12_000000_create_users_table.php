<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->date('tgl_lahir')->nullable();
            // $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password_text')->nullable();
            $table->string('password');
            $table->integer('kelas_id')->unsigned();
            $table->string('foto')->nullable();

            $table->integer('nomor')->unsigned()->default(0);
            $table->integer('ruang')->unsigned()->default(0);
            $table->integer('sesi')->unsigned()->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
