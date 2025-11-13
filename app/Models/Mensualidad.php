<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    /** @use HasFactory<\Database\Factories\MensualidadFactory> */
    use HasFactory;

        protected $fillable = [
            'monto',
            'fecha_vencimiento',
            'estado',
            'enabled',
            'usuario_id'
        ];

        // relacion uno a uno con pago
    public function pago(){
        return $this->hasOne(Pago::class,'mensualidad_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'usuario_id');
    }
}
