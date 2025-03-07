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
                'id' => $this->estudiante_id,
                'nombre' => $this->estudiante->name,
                'apellidos'=> $this->estudiante->last_name,
                'colegio' => $this->estudiante->colegio
            ]
        ];
    }
}
