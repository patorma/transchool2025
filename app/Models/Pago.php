<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    use HasFactory;

    protected $fillable =[
        'fecha_pago',
        'mensualidad_id'

    ];
    //se queda con el id de mensualidad
    public function mensualidad(){
        return $this->belongsTo(Mensualidad::class,'mensualidad_id');
    }


//     public function user(){
//         // un estudiante pertene a un usuario apoderado
//       return $this->belongsTo(User::class,'usuario_id');
//   }
//quede acá
  public function calcularMulta(){
    $diasDiferencia = 0;
      if($this->fecha_pago){
        //busca en la tabla mensualidad la fecha de vencimiento
        $fechaVencimiento = Carbon::parse(Mensualidad::find($this->mensualidad_id)->fecha_vencimiento);
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
