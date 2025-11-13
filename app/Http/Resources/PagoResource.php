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
              'fecha_pago' => $this-> fecha_pago,
              'multa' => $this->multa,
              'total' => $this->monto + $this->multa,
              'mensualidad' =>[
                 'id' => $this->mensualidad_id,
                 'monto' => $this->mensualidad->fecha_vencimiento ?? null,
                 'estado' => $this->mensualidad->estado ?? null,
                 'enabled' =>  $this->mensualidad->enabled ?? null
              ]
        ];
    }
}
