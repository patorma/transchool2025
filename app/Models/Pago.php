<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable =[
        'monto',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
        'usuario_i'

    ];


    public function user(){
        // un estudiante pertene a un usuario apoderado
      return $this->belongsTo(User::class);
  }

}
