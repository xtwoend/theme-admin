<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UjianSiswa extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'soals' => 'array',
        'last_submit' => 'datetime', 
        'lose_time' => 'datetime'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ujian_id', 'ip', 'soals', 'status', 'last_submit', 'lose_time'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Entities\User::class, 'user_id');
    }

    public function ujian()
    {
        return $this->belongsTo(\App\Entities\Ujian::class, 'ujian_id');
    }

    public function detail()
    {
        return $this->hasMany(\App\Entities\UjianSiswaDetail::class, 'ujian_siswa_id');
    }

    public function soal()
    {
        return $this->belongsToMany(\App\Entities\Soal::class, 'ujian_siswa_details', 'ujian_siswa_id', 'soal_id')->withPivot('jawaban', 'jawaban_text', 'waktu_jawab', 'status')->withTimestamps();
    }
}
