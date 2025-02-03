<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecorridoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'descripcion' => $this->descripcion,
            'estudiante'=> [
                'id' => $this->estuidiante_id,
                'nombre' => $this->estudiante->name,
                'apellidos'=> $this->estudiante->lastname,
                'colegio' => $this->estudiante->colegio
            ]
        ];
    }
}
