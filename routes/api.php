<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;

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
Route::post('login', [AuthController::class, 'store']);
Route::post('register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (){
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('logout', [AuthController::class, 'destroy']);
});
