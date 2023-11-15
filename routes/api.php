<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SavingsMovementsController;

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
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (){
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('logout', [AuthController::class, 'destroy']);

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index']);
        // Route::apiResource('transfers', TransferController::class)->ignore(['destroy', 'update']);
    });

    Route::prefix('savings')->group(function () {
        Route::get('/', [SavingsController::class, 'index']);
        // Route::apiResource('savings-movements', SavingsMovementsController::class)->ignore(['destroy', 'update']);
    });

    Route::prefix('transfer')->group(function () {
        Route::get('/', [TransferController::class, 'index']);
    });

    Route::prefix('card')->group(function (){
        Route::get('/', [CardController::class, 'index']);
    });

    // Route::apiResource('cards', CardController::class);
});

