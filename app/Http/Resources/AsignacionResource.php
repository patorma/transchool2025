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
                'colegio' => $this->estudiante->colegio,
                'apoderado' =>[
                    'id' =>$this->estudiante->usuario_id,
                    'nombres' => $this->estudiante->user->name,
                    'apellidos' => $this->estudiante->user->last_name,
                    'comuna' => $this->estudiante->user->comuna,
                    'rol' => $this->estudiante->user->role,
                ]
            ],
            'furgon' => [
                 'id'=> $this->furgon_id,
                 'patente' => $this->furgon->patente,
                 'descripcion' => $this->furgon->descripcion,
                 'transportista' => [
                    'id' => $this->furgon->usuario_id,
                    'nombres' => $this->furgon->user->name,
                     'apellidos'=> $this->furgon->user->last_name,
                     'rol' => $this->furgon->user->role
                    ]
                 ],
            'recorrido' =>[
                'id' => $this->recorrido_id,
                'origen' => $this->origen,
                'destino' => $this->destino,
                'descripcion' => $this->descripcion
            ]
        ];
    }
}
