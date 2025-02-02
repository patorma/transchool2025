<?php

namespace App\Http\Controllers;

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

        ]);
    }
}
