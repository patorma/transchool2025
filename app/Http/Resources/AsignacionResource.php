<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AsignacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha_registro'=> $this->fecha_registro,
            'estudiante'=> [
                'id' => $this->estudiante_id,
                'nombre' => $this->estudiante->name,
                'apellidos'=> $this->estudiante->last_name,
                'colegio' => $this->estudiante->colegio
            ],
            'furgon' => [
                 'id'=> $this->furgon_id,
                 'patente' => $this->furgon->patente,
                 'descripcion' => $this->furgon->descripcion
            ]
        ];
    }
}
