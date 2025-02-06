<?php

use App\Http\Controllers\AsignacionesDeEstudiantesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\FurgonController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecorridoController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsApoderado;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//PUBLIC ROUTES
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

//PRIVATE ROUTES
Route::middleware(IsUserAuth::class)->group(function(){
   Route::controller(AuthController::class)->group(function(){
      Route::post('logout','logout');
      Route::get('me','getUser');

   });

   Route::controller(EstudianteController::class)->group(function(){

    Route::get('estudiantes','getEstudiantes');
    Route::get('/estudiante/{id}','getEstudianteById');
   });

   Route::controller(PagoController::class)->group(function(){
    Route::get('pagos','getPagos');
   });

   Route::middleware([IsAdmin::class])->group(function(){

    Route::controller(PagoController::class)->group(function(){
         Route::post('pagos','addPagos');
         Route::get('/pago/{id}','getPagoById');
         Route::patch('/pago/{id}','updatePagoById');
         Route::delete('/pago/{id}','deletePagoById');

    });
    //Ver usuarios registrados por parte del admin
    Route::controller(AuthController::class)->group(function(){
        Route::get('users','getUsers');
        Route::delete('user/{id}','deleteUserById');
        Route::patch('/user/{id}','updateUserById');
    });

    //Modulo de Furgones Ingresados por admin
    Route::controller(FurgonController::class)->group(function(){
        Route::post('furgones','addFurgon');
        Route::patch('/furgon/{id}','updateFurgonoById');
        Route::get('furgones','getFurgones');
        Route::get('/furgon/{id}','getFurgonById');
        Route::delete('/furgon/{id}','deleteFurgonById');
    });

    Route::controller(RecorridoController::class)->group(function(){
        Route::post('recorrido','addRecorrido');
        Route::patch('/recorrido/{id}','updateRecorridoById');
        Route::get('recorridos','getRecorridos');
        Route::get('/recorrido/{id}','getRecorridoById');
        Route::delete('/recorrido/{id}','deleteRecorridoById');
    });

    Route::controller(AsignacionesDeEstudiantesController::class)->group(function(){
        Route::post('asignacion','addAsignacion');
        Route::patch('/asignacion/{id}','updateAsignacionById');
        Route::get('asignaciones','getAsignaciones');
        Route::get('/asignacion/{id}','getAsignacionById');
        Route::delete('/asignacion/{id}','deleteById');
    });
   });

   Route::middleware([IsApoderado::class])->group(function(){
        Route::controller(EstudianteController::class)->group(function(){
            Route::post('estudiante','addEstudiante');
            Route::patch('/estudiante/{id}','updateEstudianteById');
            Route::delete('/estudiante/{id}','deleteEstudianteById');
        });


   });
} );
