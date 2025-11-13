<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecorridoResource;
use App\Models\Recorrido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecorridoController extends Controller
{
    public function addRecorrido(Request $request){
        $validator = Validator::make($request->all(),[
            'origen' => 'required|string|min:10|max:250',
            'destino' => 'required|string|min:10|max:250',
            'descripcion'=> 'required|string|min:5|max:300',
        ]);


        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        $recorrido= Recorrido::create([
            'origen' => $request->get('origen'),
            'destino' => $request->get('destino'),
            'descripcion' => $request->get('descripcion'),

        ]);

        return (new RecorridoResource($recorrido))->additional([
            'message' =>'Recorrido created succesfully'
        ]);
    }

    public function updateRecorridoById(Request $request,$id){
        $recorrido = Recorrido::find($id);
        if(!$recorrido){
            return response()->json(['message' => 'Recorrido not found'],404);
        }

        $validator = Validator::make($request->all(),[
            'origen' => 'sometimes|string|min:10|max:250',
            'destino' => 'sometimes|string|min:10|max:250',
            'descripcion'=> 'sometimes|string|min:5|max:300',
            //'estudiante_id' =>'sometimes|exists:estudiantes,id'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('origen')){
            $recorrido->origen = $request->origen;
        }
        if($request->has('destino')){
            $recorrido->destino = $request->destino;
        }
        //verifica si viene el peticion http el valor de descripcion
        if($request->has('descripcion')){
            $recorrido->descripcion = $request->descripcion;
        }

        $recorrido->update();
        return (new RecorridoResource($recorrido))->additional([
              'message' => 'Recorrido updated successfully'
        ]);
    }

    public function getRecorridos(){
        $recorridos = Recorrido::paginate(10);

        if($recorridos->isEmpty()){
            return response()->json(['message'=> 'No Recorridos found']);
        }

        return RecorridoResource::collection($recorridos);
    }

    public function getRecorridoById($id){
        $recorrido = Recorrido::find($id);

        if(!$recorrido){
            return response()->json(['message' => 'Recorrido not found'],404);
        }

      //  $recorrido->load('estudiante');

        return new RecorridoResource($recorrido);
    }

    public function deleteRecorridoById($id){
        $recorrido = Recorrido::find($id);
        if(!$recorrido){
            return response()->json(['message'=>'Recorrido not found'.' '.'con el id:'.' '.$id],404);
        }

        $recorrido->delete();
        return response()->json(['message' => 'Recorrido deleted successfully'.' ' .'con el id:'.' '.$id],200);
    }
}
