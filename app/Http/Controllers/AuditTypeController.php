<?php

namespace App\Http\Controllers;

use App\Models\AuditType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $auditTypes = AuditType::all();

            // Transform data to match frontend format
            $transformedAuditTypes = $auditTypes->map(function ($auditType) {
                return [
                    'id' => $auditType->aud_typ_id,
                    'name' => $auditType->aud_typ_name,
                    'active' => $auditType->aud_typ_active,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAuditTypes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch audit types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'aud_typ_id' => 'required|integer|min:0|max:127|unique:tblaudit_types,aud_typ_id',
                'aud_typ_name' => 'required|string|max:50',
                'aud_typ_active' => 'required|integer|in:0,1',
            ]);

            $auditType = AuditType::create($validated);

            $transformedAuditType = [
                'id' => $auditType->aud_typ_id,
                'name' => $auditType->aud_typ_name,
                'active' => $auditType->aud_typ_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit type created successfully',
                'data' => $transformedAuditType
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create audit type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $auditType = AuditType::findOrFail($id);

            $transformedAuditType = [
                'id' => $auditType->aud_typ_id,
                'name' => $auditType->aud_typ_name,
                'active' => $auditType->aud_typ_active,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedAuditType
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Audit type not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $auditType = AuditType::findOrFail($id);

            $validated = $request->validate([
                'aud_typ_name' => 'sometimes|required|string|max:50',
                'aud_typ_active' => 'sometimes|required|integer|in:0,1',
            ]);

            $auditType->update($validated);

            $transformedAuditType = [
                'id' => $auditType->aud_typ_id,
                'name' => $auditType->aud_typ_name,
                'active' => $auditType->aud_typ_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit type updated successfully',
                'data' => $transformedAuditType
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update audit type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $auditType = AuditType::findOrFail($id);
            $auditType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Audit type deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete audit type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
