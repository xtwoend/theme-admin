<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'opsi' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mapel_id', 'pertanyaan', 'opsi', 'kunci', 'audio', 'type', 'kategori'
    ];

    public function mapel()
    {
        return $this->belongsTo(\App\Entities\Mapel::class, 'mapel_id');
    }
}
