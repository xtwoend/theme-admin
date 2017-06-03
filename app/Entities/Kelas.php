<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'keterangan', 'tingkat', 'jurusan_id'
    ];


    public function jurusan()
    {
        return $this->belongsTo(\App\Entities\Jurusan::class, 'jurusan_id');
    }
}
