<?php

use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


route::middleware(['auth:sanctum', SecuriseRoute::class])->group(function(){

    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



});
Route::post('/inscription', [AuthController::class,'register'])->name('inscription');
Route::post('/login', [AuthController::class,'login'])->name("login");





// Methode d'insertion du theme
Route::post('storeTheme',[ThemeController::class,'create']);

// Methode de suppression du theme
Route::get('deleteTheme/{id}',[ThemeController::class,'delete']);
