<?php

namespace App\Http\Controllers;

use App\Http\Resources\FurgonResource;
use App\Models\Furgon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FurgonController extends Controller
{
    public function addFurgon(Request $request){
        $validator = Validator::make($request->all(),[
           'patente' => 'required|string|min:8|max:8',
            'descripcion' => 'required|string|min:10',
             'usuario_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }
      //  $usuario = User::find($request->get('usuario_id'));
      //  $user = auth('api')->user();
        $user_transportista= User::where('id',$request->get('usuario_id'))
                                 ->where('role','transportista')
                                 ->first();
        if(!$user_transportista){
            return response()->json(['error' => 'El usuario seleccionado no tiene el rol de transportista.'], 400);
        }
        //if($user->role === 'transportista'){
                       // Comprobamos si la patente ya existe
           $existingFurgon = Furgon::where('patente', $request->get('patente'))->first();
           if ($existingFurgon) {
                    return response()->json(['error' => 'La patente ya existe en la base de datos.'], 400);
           }
      //  } else return response()->json(['error' => 'El usuario seleccionado no tiene el rol de transportista.'], 400);

        // if (  !$usuario || !$user->role ==='transportista') {
        //     return response()->json(['error' => 'El usuario seleccionado no tiene el rol de transportista.'], 400);
        // }

        //    if ($existingFurgon) {
        //        return response()->json(['error' => 'La patente ya existe en la base de datos.'], 400);
        //    }

        //$usuario_id = auth()->id();
        $furgon =Furgon::create([
            'patente'=> $request->get('patente'),
            'descripcion' =>$request->get('descripcion'),
            'usuario_id' => $request->get('usuario_id'),
        ]);



        return (new FurgonResource($furgon))->additional(['message' => 'Furgon created succesfully']);
    }

    public function updateFurgonoById(Request $request,$id){
        $furgon = Furgon::find($id);
         if(!$furgon){
            return response()->json(['message' => 'Furgon not found'],404);
         }

         $validator = Validator::make($request->all(),[
            'patente' => 'sometimes|string|min:8|max:8',
             'descripcion' => 'sometimes|text|min:10'
         ]);

         if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('patente')){
            $furgon->patente = $request->patente;
        }
        if($request->has('descripcion')){
            $furgon->descripcion = $request->descripcion;
        }

        $furgon->update();
        return (new FurgonResource($furgon))->additional([
            'message'=> 'Furgon updated successfully'
        ]);
    }

    public function getFurgones(){
        $furgones = Furgon::with('user')->paginate(10);
        if($furgones->isEmpty()){
            return response()->json(['message'=> 'No furgones found']);
        }

        return FurgonResource::collection($furgones);
    }

    public function getFurgonById($id){
        $furgon = Furgon::with('user')->find($id);
        if(!$furgon){
            return response()->json(['message' => 'Furgon not found'],404);
        }
        $furgon->load('user');
        return new FurgonResource($furgon);
    }

    public function deleteFurgonById($id){
        $furgon = Furgon::find($id);
        if(!$furgon){
            return response()->json(['message'=>'Furgon not found'],404);
        }
        $furgon->delete();
        return response()->json(['message' => 'Furgon deleted successfully'],200);
    }



}
