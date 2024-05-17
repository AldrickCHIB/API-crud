<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PeopleControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::get('/people', [PeopleControler::class, 'index']);

Route::get('/people/{id}', [PeopleControler::class, 'show']);

Route::post('/people', [PeopleControler::class, 'store']);

Route::put('/people/{id}', [PeopleControler::class, 'update']);

Route::delete('/people/{id}', [PeopleControler::class, 'destroy']);

//esta ruta pues no se usa es una get all de carros
Route::get('/car', [CarController::class,'index']);

Route::get('/car/carOne/{id}', [CarController::class, 'show']);

Route::get('/car/{people_id}', [CarController::class,'showByPeopleId']);

Route::post('/car', [CarController::class,'store']);

Route::put('/car/{id}', [CarController::class, 'update']);


Route::delete('/car/{id}', [CarController::class, 'destroy']);
