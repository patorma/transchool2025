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
    protected $table = 'furgones';

    public function user(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function asignaciones(){
        return $this->hasMany(AsignacionesDeEstudiantes::class);
    }
}
