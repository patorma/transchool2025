<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstudianteResource extends JsonResource
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
            'name' => $this->name,
            'last_name' => $this->last_name,
            'fecha_nacimiento' => $this-> fecha_nacimiento,
            'colegio' => $this-> colegio,
            'usuario' =>[
                'id' => $this->usuario_id,
                'nombres' => $this->user->name ?? null,
                'apellidos' => $this->user->last_name ?? null,
                 'rol' =>  $this->user->role ?? null
             ]
        ];
    }
}
