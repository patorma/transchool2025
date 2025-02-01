<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    protected $fillable = [
        'descripcion',
        'estudiante_id'
    ];

    public function estudiante(){
        return $this->belongsTo(Estudiante::class);
    }
}
