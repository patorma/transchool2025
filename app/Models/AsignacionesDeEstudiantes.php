<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionesDeEstudiantes extends Model
{
    use HasFactory;

    protected $fillable =[
        'fecha_registro',
         'estudiante_id',
         'furgon_id'
     ];

     public function estudiante(){
        return $this->belongsTo(Estudiante::class,'estudiante_id');
     }

     public function furgon(){
        return $this->belongsTo(Furgon::class,'furgon_id');
     }
}
