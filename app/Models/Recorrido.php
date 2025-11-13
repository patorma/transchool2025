<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    protected $fillable = [
        'origen',
        'destino',
        'descripcion'

    ];

   public function asignaciones(){
     return $this->hasMany(AsignacionesDeEstudiantes::class);
   }
}
