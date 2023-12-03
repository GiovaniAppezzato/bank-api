<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SavingsMovementsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PixKeyController;
use App\Http\Controllers\PixMovementController;

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
    Route::delete('logout', [AuthController::class, 'destroy']);

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/', [UserController::class, 'update']);
        Route::put('/confirm-password', [UserController::class, 'confirmPassword']);
    });

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index']);
        Route::apiResource('transfers', TransferController::class)->only(['index', 'store']);
    });

    Route::prefix('savings')->group(function () {
        Route::get('/', [SavingsController::class, 'index']);
        Route::apiResource('savings-movements', SavingsMovementsController::class)->except(['destroy', 'update']);
    });

    Route::apiResource('pix-movements', PixMovementController::class)->only(['index', 'store']);
    Route::get('pix-movements/get-account-by-pix-key/{pixKey}', [PixMovementController::class, 'getAccountByPixKey']);

    Route::apiResource('pix-keys', PixKeyController::class)->except(['show', 'update']);
    Route::apiResource('cards', CardController::class)->only(['index', 'store']);
});

