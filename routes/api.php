<?php

use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Middleware\VerifyBearerToken;

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


route::middleware(['auth:sanctum', VerifyBearerToken::class])->group(function(){

    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    // Methode d'insertion du theme
Route::post('storeTheme',[ThemeController::class,'create']);
// Methode de suppression du theme
Route::delete('deleteTheme/{id}',[ThemeController::class,'delete']);

Route::post('/questions', [QuestionController::class, 'store']);

Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
Route::post('/questions/{id}', [QuestionController::class, 'update']);
Route::get('/editquestion/{id}',[QuestionController::class,'edit']);



});


Route::post('/inscription', [AuthController::class,'register'])->name('inscription');
Route::post('/login', [AuthController::class,'login'])->name("login");
Route::get('/question', [QuestionController::class, 'index']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);









