<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_sekolah', 'status_sekolah', 'jenjang', 'alamat', 'email', 'telp', 'jumlah_ruang', 'jumlah_unit', 'logo'
    ];
}
