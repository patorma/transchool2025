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
            'descripcion'=> 'required|string|min:10|max:300',
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

    }
}
