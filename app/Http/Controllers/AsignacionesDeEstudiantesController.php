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
            'estudiante_id' => 'required|unique:asignaciones_de_estudiantes|exists:estudiantes,id',
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

    public function updateAsignacionById(Request $request, $id){
        $asignacion = AsignacionesDeEstudiantes::find($id);
        if(!$asignacion){
            return response()->json(['message' => 'Asignación not found'],404);
        }

        $validator = Validator::make($request->all(),[
             'fecha_registro'=> 'sometimes|date',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('fecha_registro')){
            $asignacion->fecha_registro = $request->fecha_registro;
        }

        $asignacion->update();
        return  (new AsignacionResource($asignacion))->additional([
            'message' => 'Asignacion updated successfully'
        ]);
    }

    public function getAsignaciones(){
        $asignaciones = AsignacionesDeEstudiantes::with('estudiante','furgon')->paginate(10);

        if($asignaciones->isEmpty()){
            return response()->json(['message'=> 'No Asignaciones found']);
        }

        return AsignacionResource::collection($asignaciones);
    }

    public function getAsignacionById($id){
        $asignacion = AsignacionesDeEstudiantes::with('estudiante','furgon')->find($id);

        if(!$asignacion){
            return response()->json(['message' => 'Asignacion not found'],404);
        }

        $asignacion->load('estudiante','furgon');

        return new AsignacionResource($asignacion);
    }

    public function deleteById($id){
        $asignacion = AsignacionesDeEstudiantes::find($id);
        if(!$asignacion){
            return response()->json(['message'=>'Asignacion not found'.' '.'con el id:'.' '.$id],404);
        }

        $asignacion->delete();
        return response()->json(['message' => 'Asignacion deleted successfully'.' ' .'con el id:'.' '.$id],200);
    }
}
