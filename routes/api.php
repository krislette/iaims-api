<?php

use App\Http\Controllers\{
    AgencyController,
    AuditAreaController,
    AuditCriteriaController,
    AuditorController,
    AuditTypeController,
    AuthController,
    DocumentTypeController,
    InternalControlController,
    UserAccountController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------|
 * | API Routes                                                               |
 * |--------------------------------------------------------------------------|
 */

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Current user info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Versioned API routes (v1)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('agencies', AgencyController::class);
    Route::apiResource('auditors', AuditorController::class);
    Route::apiResource('audit-areas', AuditAreaController::class);
    Route::apiResource('audit-criteria', AuditCriteriaController::class);
    Route::apiResource('internal-controls', InternalControlController::class);
    Route::apiResource('document-types', DocumentTypeController::class);
    Route::apiResource('audit-types', AuditTypeController::class);
    Route::apiResource('user-accounts', UserAccountController::class);
});
