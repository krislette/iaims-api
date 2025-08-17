<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * .------------.
 * | API Routes |
 * '------------'
 */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Agency routes
Route::prefix('v1')->group(function () {
    Route::apiResource('agencies', AgencyController::class);
});
