<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nis', 'nisn', 'name', 'gender', 'tgl_lahir', 'password', 'password_text', 'kelas_id', 'foto', 'nomor', 'ruang', 'sesi'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'password_text'
    ];

    /**
     * [kelas description]
     * @return [type] [description]
     */
    public function kelas()
    {
        return $this->belongsTo(\App\Entities\Kelas::class, 'kelas_id');
    }
}
