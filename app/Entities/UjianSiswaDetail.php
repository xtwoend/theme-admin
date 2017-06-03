<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UjianSiswaDetail extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ujian_siswa_id', 'soal_id', 'no_urut', 'jawaban', 'jawaban_text', 'kunci', 'nilai', 'status', 'waktu_jawab', 'waktu_koreksi'
    ];

    public function ujian()
    {
        return $this->belongsTo(\App\Entities\UjianSiswa::class, 'ujian_siswa_id');
    }

    public function soal()
    {
        return $this->belongsTo(\App\Entities\Soal::class, 'soal_id');
    }
}
