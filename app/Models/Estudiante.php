<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable =[
       'name',
       'last_name',
       'fecha_nacimiento',
       'colegio',
       'usuario_id'
    ];

    public function user(){
          // un estudiante pertene a un usuario apoderado
        return $this->belongsTo(User::class);
    }

    public function asignaciones_de_estudiantes(){
        return $this->hasMany(AsignacionesDeEstudiantes::class);
    }

    public function recorridos(){
        return $this->hasMany(Recorrido::class);
    }
}
