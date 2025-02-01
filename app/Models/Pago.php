<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    use HasFactory;

    protected $fillable =[
        'monto',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
        'usuario_id'

    ];


    public function user(){
        // un estudiante pertene a un usuario apoderado
      return $this->belongsTo(User::class,'usuario_id');
  }

  public function calcularMulta(){
      if($this->fecha_pago){
        $fechaVencimiento = Carbon::parse($this->fecha_vencimiento);
        $fechaPago = Carbon::parse($this->fecha_pago);
        $diasDiferencia = $fechaVencimiento->diffInDays($fechaPago, false);
      }

      if ($diasDiferencia > 10) {
        $this->multa = round($this->monto * 0.10); // Multa del 10% del monto
    } else {
        $this->multa = 0;
    }

    $this->save();
  }
}
