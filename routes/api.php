<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Logcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/rigester',[AuthController::class,'rigester']);
Route::post('/login',[AuthController::class,'login']);



Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

Route::post('/logout',[AuthController::class,'logout']);

Route::post('/create',[HabitController::class,'create_habit']);
Route::get('/habits',[HabitController::class,'habits_all']);
Route::get('/habit_detail/{id}',[HabitController::class,'habit_detail']);
Route::get('/delete_habits/{id}',[HabitController::class,'delete']);
Route::put('/apdate_habit/{id}',[HabitController::class,'apdate_habit']);

Route::post('mark_completed/{id}/log',[Logcontroller::class,'mark_completed']);
Route::get('log_Historique/{id}/log',[Logcontroller::class,'log_Historique']);
Route::get('delete_log/{h_id}/log{l_id}',[Logcontroller::class,'delete_log']);
Route::get('habit/{id}/stats',[Logcontroller::class,'stats']);


Route::get('/user', function (Request $request) {
    return $request->user();
});
});