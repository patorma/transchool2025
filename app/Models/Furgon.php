<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furgon extends Model
{
    use HasFactory;

    protected $fillable =[
        'patente',
        'descripcion',
        'usuario_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function asignaciones(){
        return $this->hasMany(AsignacionesDeEstudiantes::class);
    }
}
