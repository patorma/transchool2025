<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagoController;
use App\Http\Middleware\IsAdmin;
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

   Route::middleware([IsAdmin::class])->group(function(){

    Route::controller(PagoController::class)->group(function(){
         Route::post('pagos','addPagos');
         Route::get('/pago/{id}','getPagoById');
         Route::patch('/pago/{id}','updatePagoById');
         Route::delete('/pago/{id}','deletePagoById');
         Route::get('pagos','getPagos');
    });
    Route::controller(AuthController::class)->group(function(){
        Route::get('users','getUsers');
    });
   });
} );
