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
            'descripcion'=> 'required|string|min:5|max:300',
            'estudiante_id' =>'required|exists:estudiantes,id'
        ]);


        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        $recorrido= Recorrido::create([
            'descripcion' => $request->get('descripcion'),
            'estudiante_id' => $request->get('estudiante_id')
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
             'descripcion'=> 'sometimes|string|min:5|max:300',
            //'estudiante_id' =>'sometimes|exists:estudiantes,id'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }
        if($request->has('descripcion')){
            $recorrido->descripcion = $request->descripcion;
        }

        $recorrido->update();
        return (new RecorridoResource($recorrido))->additional([
              'message' => 'Recorrido updated successfully'
        ]);
    }

    public function getRecorridos(){
        $recorridos = Recorrido::with('estudiante')->paginate(10);

        if($recorridos->isEmpty()){
            return response()->json(['message'=> 'No Recorridos found']);
        }

        return RecorridoResource::collection($recorridos);
    }

    public function getRecorridoById($id){
        $recorrido = Recorrido::with('estudiante')->find($id);

        if(!$recorrido){
            return response()->json(['message' => 'Recorrido not found'],404);
        }

        $recorrido->load('estudiante');

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
