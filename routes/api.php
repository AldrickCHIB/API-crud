<?php

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