<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{   

    /**
     * [$dates description]
     * @var [type]
     */
    protected $dates = [
        'waktu_mulai', 'waktu_berakhir'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'mapel_id', 'paket_soal_id', 'jumlah_soal', 'soal_pg', 'soal_essay', 'waktu_mulai', 'waktu_berakhir', 'lama_waktu', 'batas_terlambat', 'status', 'soal_acak', 'opsi_acak', 'token'
    ];

    public function mapel()
    {
        return $this->belongsTo(\App\Entities\Mapel::class, 'mapel_id');
    }

    public function paket()
    {
        return $this->belongsTo(\App\Entities\PaketSoal::class, 'paket_soal_id');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeNoExpired($query)
    {
        $query->where('waktu_berakhir', '>=', Carbon::now());
    }
}
