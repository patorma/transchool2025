<?php

namespace App\Http\Controllers;

use App\Http\Resources\PagoResource;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{
    public function addPagos(Request $request){
        $validator = Validator::make($request->all(),[
            'monto' => 'required|numeric|min:0|max:9999999',
            'fecha_vencimiento' => 'required|date',
            'fecha_pago' => 'date|nullable',



        ]);
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }
        $usuario_id = auth()->id();
        $pago = Pago::create([
            'monto' => $request->get('monto'),
            'fecha_vencimiento' => $request->get('fecha_vencimiento'),
            'fecha_pago' => $request->get('fecha_pago'),
             'estado' => 'pendiente',
            'usuario_id' => $usuario_id,

        ]);

        return (new PagoResource($pago))->additional(['message' =>'Pago created succesfully']);

    }

    public function updatePagoById(Request $request,$id){
        $pago = Pago::find($id);
        if(!$pago){
            return response()->json(['message' => 'User not found'],404);
        }
        $validator = Validator::make($request->all(),[
            'monto' => 'sometimes|integer|min:4|max:10',
            'fecha_vencimiento' => 'sometimes|date',
            'fecha_pago' => 'sometimes|date|nullable',
            'estado' => 'sometimes|string|in:pendiente,pagado,vencido'
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('monto')){
            $pago->monto = $request->monto;
        }
        if($request->has('fecha_vencimiento')){
            $pago->fecha_vencimiento = $request->fecha_vencimiento;
        }
        if($request->has('fecha_pago')){
            $pago->fecha_pago = $request->fecha_pago;
            $pago->calcularMulta();
        }
        if($request->has('estado')){
            $pago->estado = $request->estado;
        }

        $pago->update();
        return (new PagoResource($pago))->additional([
             'message' => 'Pago updated successfully'
        ]);

    }

    public function getPagos(){
        $pagos = Pago::with('user')->paginate(10);
        if($pagos->isEmpty()){
            return response()->json(['message'=> 'No pagos found']);
        }

        return PagoResource::collection($pagos);
    }

    public function getPagoById($id){
        $pago =Pago::with('user')->find($id);
        if(!$pago){
            return response()->json(['message' => 'Pago not found'],404);
        }

        return new PagoResource($pago);
    }

    public function deletePagoById($id){
         $pago = Pago::find($id);
         if(!$pago){
            return response()->json(['message'=>'Pago not found'],404);
         }
         $pago->delete();
         return response()->json(['message' => 'Pago deleted successfully'],200);
    }
}
