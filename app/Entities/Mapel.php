<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'keterangan'
    ];
}
