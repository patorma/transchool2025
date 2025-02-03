<?php

namespace App\Http\Controllers;

use App\Http\Resources\AsignacionResource;
use App\Models\AsignacionesDeEstudiantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsignacionesDeEstudiantesController extends Controller
{

    public function addAsignacion(Request $request){
        $validator = Validator::make($request->all(),[
            'fecha_registro'=> 'required|date',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'furgon_id' => 'required|exists:furgones,id'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        $asignacion= AsignacionesDeEstudiantes::create([
            'fecha_registro' => $request->get('fecha_registro'),
            'estudiante_id' => $request->get('estudiante_id'),
            'furgon_id' => $request->get('furgon_id')
        ]);

        return (new AsignacionResource($asignacion))->additional([
          'message' => 'Asignacion created succesfully'
        ]);
    }
}
