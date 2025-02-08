<?php

namespace App\Http\Controllers;

use App\Http\Resources\AsignacionResource;
use App\Models\AsignacionesDeEstudiantes;
use App\Models\Estudiante;
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
        //  $existingEstudiante = AsignacionesDeEstudiantes::where('estudiante_id',$request->get('estudiante_id'))->first();

        //  if($existingEstudiante){
        //     return response()->json(['error' => 'El estudiante ya existe en la base de datos.'], 400);
        //  }

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

    public function getAsignaciones(Request $request){

        $usuario_id = auth()->id();
        $user = auth('api')->user();
        if($user->role === 'admin'){
            $asignaciones = AsignacionesDeEstudiantes::with('estudiante', 'furgon.user')
            ->paginate(10);
            return $asignaciones->isEmpty()?
            response()->json(['message'=>'No Asignaciones found']):AsignacionResource::collection($asignaciones);
        }if($user->role === 'apoderado'){
           return  response()->json(['message'=>'Eres apoderado no tienes acceso a este recurso']);
        }

        $asignaciones = AsignacionesDeEstudiantes::whereHas('furgon', function ($query) use ($usuario_id) {
            $query->where('usuario_id', $usuario_id);
        })->with('estudiante', 'furgon.user')
          ->get();

        if($asignaciones->isEmpty()){
            return response()->json(['message'=> 'No Asignaciones found']);
        }

        return AsignacionResource::collection($asignaciones);
    }

    public function getAsignacionById($id){
        $user = auth('api')->user();
        if($user->role === 'apoderado'){
            return  response()->json(['message'=>'Eres apoderado no tienes acceso a este recurso']);
         }

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
