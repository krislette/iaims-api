<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuditAreaController;
use App\Http\Controllers\AuditCriteriaController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InternalControlController;
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

// V1 routes
Route::prefix('v1')->group(function () {
    Route::apiResource('agencies', AgencyController::class);
    Route::apiResource('auditors', AuditorController::class);
    Route::apiResource('audit-areas', AuditAreaController::class);
    Route::apiResource('audit-criteria', AuditCriteriaController::class);
    Route::apiResource('internal-controls', InternalControlController::class);
});
