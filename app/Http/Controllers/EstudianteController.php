<?php

namespace App\Http\Controllers;

use App\Http\Resources\EstudianteResource;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    public function addEstudiante(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|min:4|max:300',
            'last_name'=>'required|string|min:4|max:300',
            'fecha_nacimiento' => 'required|date',
            'colegio'=> 'required|string|min:4|max:200',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }
        $usuario_id = auth()->id();
        $estudiante = Estudiante::create([
            'name'=> $request->get('name'),
            'last_name'=> $request->get('last_name'),
            'fecha_nacimiento' => $request->get('fecha_nacimiento'),
            'colegio'=> $request->get('colegio'),
            'usuario_id' => $usuario_id
        ]);

        return (new EstudianteResource($estudiante))->additional(['message' =>'Estudiante created succesfully']);
    }

    public function updateEstudianteById(Request $request,$id){
        // $furgon = Furgon::with('user')->find($id);
        $estudiante = Estudiante::find($id);

        if(!$estudiante){
            return response()->json(['message' => 'Estudiante not found'],404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'sometimes|string|min:4|max:300',
            'last_name'=>'sometimes|string|min:4|max:300',
            'fecha_nacimiento' => 'sometimes|date',
            'colegio'=> 'sometimes|string|min:4|max:200',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('name')){
            $estudiante->name = $request->name;
        }
        if($request->has('last_name')){
            $estudiante->last_name = $request->last_name;
        }
        if($request->has('fecha_nacimiento')){
            $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
        }
        if($request->has('colegio')){
            $estudiante->colegio = $request->colegio;
        }
       $estudiante->update();

       return (new EstudianteResource($estudiante))->additional([
        'message' => 'Estudiante updated successfully'
       ]);
    }

    public function getEstudiantes(){
        $estudiantes = Estudiante::with('user')->paginate(10);
        if($estudiantes->isEmpty()){
            return response()->json(['message'=> 'No Estudiantes found']);
        }

        return EstudianteResource::collection($estudiantes);
    }

    public function getEstudianteById($id){
        $estudiante = Estudiante::with('user')->find($id);

        if(!$estudiante){
            return response()->json(['message' => 'Estudiante not found'],404);
        }

        $estudiante->load('user');

        return new EstudianteResource($estudiante);
    }


    public function deleteEstudianteById($id){
        $estudiante = Estudiante::find($id);
        if(!$estudiante){
            return response()->json(['message'=>'Estudiante not found'.' '.'con el id:'.' '.$id],404);
        }

        $estudiante->delete();
        return response()->json(['message' => 'Estudiante deleted successfully'.' ' .'con el id:'.' '.$id],200);
    }
}
