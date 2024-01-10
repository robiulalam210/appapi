<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/getuser',[UserController::class,'getuser']);
Route::post('/adduser',[UserController::class,'addUser']);
Route::put('/updateuser/{id}',[UserApiController::class,'updateuser']);
Route::patch('/updatesingledata/{id}',[UserApiController::class,'updatesingledata']);
Route::delete('/deletduser/{id}',[UserApiController::class,'deletduser']);

