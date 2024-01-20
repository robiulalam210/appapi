<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController,AcademicsController,ImageController,WorkExperienceController};



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


// User Data Add Get Update Single & Update All Data Delete

Route::get('/getuser/{id?}',[UserController::class,'getuser']);
Route::post('/adduser',[UserController::class,'addUser']);
Route::patch('/updatesingledata/{id}',[UserController::class,'updatesingledata']);
Route::put('/updateuser/{id}',[UserController::class,'updateuser']);
Route::delete('/deletduser/{id}',[UserController::class,'deletduser']);



// User Data Add Get Update Single & Update All Data Delete

Route::post('/academics_stor',[AcademicsController::class,'academics_stor']);
Route::get('/academics_show/{id?}',[AcademicsController::class,'academics_show']);
Route::put('/academics_update/{id}',[AcademicsController::class,'academics_update']);
Route::delete('/deleteAcademics/{id}',[AcademicsController::class,'deleteAcademics']);




Route::post('/uploadImages', [ImageController::class, 'uploadImages']);

Route::post('/workexperience_stor',[WorkExperienceController::class,'workexperience_stor']);




