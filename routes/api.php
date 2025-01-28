<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//PUBLIC ROUTES
Route::post('login',[AuthController::class,'login']);



//Route::post('register',[AuthController::class,'register']);
//PRIVATE ROUTES
Route::middleware(IsUserAuth::class)->group(function(){
   Route::controller(AuthController::class)->group(function(){
      Route::post('logout','logout');
      Route::get('me','getUser');
   });
} );
