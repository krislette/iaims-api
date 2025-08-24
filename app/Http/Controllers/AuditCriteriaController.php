<?php

namespace App\Http\Controllers;

use App\Models\AuditCriteria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $auditCriteria = AuditCriteria::all();

            // Transform data to match frontend format
            $transformedAuditCriteria = $auditCriteria->map(function ($criteria) {
                return [
                    'id' => $criteria->cra_id,
                    'name' => $criteria->cra_name,
                    'areas' => $criteria->cra_areas,
                    'references' => $criteria->cra_references,
                    'active' => $criteria->cra_active,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAuditCriteria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch audit criteria',
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
                'cra_id' => 'required|integer|unique:tblaudit_criteria,cra_id',
                'cra_name' => 'required|string|max:255',
                'cra_areas' => 'required|string|max:100',
                'cra_references' => 'required|string|max:255',
                'cra_active' => 'required|integer|in:0,1',
            ]);

            $auditCriteria = AuditCriteria::create($validated);

            $transformedAuditCriteria = [
                'id' => $auditCriteria->cra_id,
                'name' => $auditCriteria->cra_name,
                'areas' => $auditCriteria->cra_areas,
                'references' => $auditCriteria->cra_references,
                'active' => $auditCriteria->cra_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit criteria created successfully',
                'data' => $transformedAuditCriteria
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
                'message' => 'Failed to create audit criteria',
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
            $auditCriteria = AuditCriteria::findOrFail($id);

            $transformedAuditCriteria = [
                'id' => $auditCriteria->cra_id,
                'name' => $auditCriteria->cra_name,
                'areas' => $auditCriteria->cra_areas,
                'references' => $auditCriteria->cra_references,
                'active' => $auditCriteria->cra_active,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedAuditCriteria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Audit criteria not found',
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
            $auditCriteria = AuditCriteria::findOrFail($id);

            $validated = $request->validate([
                'cra_name' => 'sometimes|required|string|max:255',
                'cra_areas' => 'sometimes|required|string|max:100',
                'cra_references' => 'sometimes|required|string|max:255',
                'cra_active' => 'sometimes|required|integer|in:0,1',
            ]);

            $auditCriteria->update($validated);

            $transformedAuditCriteria = [
                'id' => $auditCriteria->cra_id,
                'name' => $auditCriteria->cra_name,
                'areas' => $auditCriteria->cra_areas,
                'references' => $auditCriteria->cra_references,
                'active' => $auditCriteria->cra_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit criteria updated successfully',
                'data' => $transformedAuditCriteria
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
                'message' => 'Failed to update audit criteria',
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
            $auditCriteria = AuditCriteria::findOrFail($id);
            $auditCriteria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Audit criteria deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete audit criteria',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
