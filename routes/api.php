<?php

use App\Http\Controllers\ThemeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Methode d'insertion du theme
Route::post('storeTheme',[ThemeController::class,'create']);

// Methode de suppression du theme
Route::get('deleteTheme/{id}',[ThemeController::class,'delete']);