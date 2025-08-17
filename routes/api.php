<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuditAreaController;
use App\Http\Controllers\AuditorController;
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

// API v1 routes
Route::prefix('v1')->group(function () {
    // Agency routes
    Route::apiResource('agencies', AgencyController::class);

    // Auditor routes
    Route::apiResource('auditors', AuditorController::class);

    // Audit area routes
    Route::apiResource('audit-areas', AuditAreaController::class);
    Route::get('audit-areas-parent-options', [AuditAreaController::class, 'getParentOptions']);
});
