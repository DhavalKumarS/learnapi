<?php

use App\Http\Controllers\api\Usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:passport')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[Usercontroller::class,'register']);


Route::post('/login',[Usercontroller::class,'login']);




Route::middleware('auth:api')->group(function(){

    Route::get('/user/get',[Usercontroller::class,'index']);
    Route::get('/user/{id}',[Usercontroller::class,'show']);
    Route::delete('/user/delete/{id}',[Usercontroller::class,'delete']);
    Route::post('/user/update/{id}',[Usercontroller::class,'update']);

});
