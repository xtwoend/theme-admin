<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUjianSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ujian_siswas', function ($table) {
            $table->integer('benar')->default(0);
            $table->integer('salah')->default(0);
            $table->integer('kosong')->default(0);
            $table->integer('skor_pg')->default(0);
            $table->integer('skor_essay')->default(0);
            $table->integer('skor')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match', function ($table) {
            $table->dropColumn(['benar', 'salah', 'kosong', 'skor_pg', 'skor_essay', 'skor']);
        });
    }
}
