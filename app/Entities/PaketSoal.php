<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PaketSoal extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'soal' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mapel_id', 'nama', 'soal', 'jumlah_soal', 'soal_pg', 'soal_essay', 'keterangan'
    ];

    public function mapel()
    {
        return $this->belongsTo(\App\Entities\Mapel::class, 'mapel_id');
    }
}
