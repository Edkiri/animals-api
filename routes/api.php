<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnimalController;

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

// Animals
Route::post('animals', [AnimalController::class, 'create']);
Route::get('animals', [AnimalController::class, 'findAll']);
Route::delete('animals/{id}', [AnimalController::class, 'delete']);
