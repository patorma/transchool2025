<?php

namespace App\Http\Controllers;

use App\Http\Resources\EstudianteResource;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteAdminController extends Controller
{
    public function getEstudiantes(){
       $estudiantes = Estudiante::paginate(10);

       return $estudiantes->isEmpty()?
          response()->json(["message" => "No hay Estudiantes"]):
          EstudianteResource::collection($estudiantes);
    }

    public function getEstudianteById($id){
     $estudiante =Estudiante::find($id);
      return !$estudiante?response()->json(['message' => 'Estudiante not found'],404):new EstudianteResource($estudiante);

    }
}
