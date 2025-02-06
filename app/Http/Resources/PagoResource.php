<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
              'id' =>  $this->id,
              'monto' => $this->monto,
              'fecha_vencimiento' => $this-> fecha_vencimiento,
              'estado' => $this->estado,
              'fecha_pago' => $this-> fecha_pago,
              'multa' => $this->multa,
              'total' => $this->monto + $this->multa,
              'usuario' =>[
                 'id' => $this->usuario_id,
                 'nombres' => $this->user->name ?? null,
                 'apellidos' => $this->user->last_name ?? null,
                  'rol' =>  $this->user->role ?? null
              ]
        ];
    }
}
