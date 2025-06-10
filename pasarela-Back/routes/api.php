<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaypalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('paypal')->group(function () {
    Route::post('/createPaypalOrder', [PaypalController::class, 'createPaypalOrder']);
    Route::post('/capturePaypalOrder', [PaypalController::class, 'capturePaypalOrder']);
});