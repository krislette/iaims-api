<?php

namespace App\Http\Controllers;

use App\Models\AuditArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $auditAreas = AuditArea::with('parent', 'children')->get();

            // Transform data to match frontend format
            $transformedAuditAreas = $auditAreas->map(function ($auditArea) {
                return [
                    'id' => $auditArea->ara_id,
                    'name' => $auditArea->ara_name,
                    'parentId' => $auditArea->ara_ara_id,
                    'parentName' => $auditArea->parent ? $auditArea->parent->ara_name : 'N/A',
                    'active' => $auditArea->ara_active,
                    'hasChildren' => $auditArea->children->count() > 0,
                    'childrenCount' => $auditArea->children->count(),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAuditAreas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch audit areas',
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
                'ara_name' => 'required|string|max:255',
                'ara_ara_id' => 'nullable|integer|min:0|max:127|exists:tblaudit_areas,ara_id',
                'ara_active' => 'required|integer|in:0,1',
            ]);

            // Check for circular reference if parent is provided
            if (!empty($validated['ara_ara_id'])) {
                if ($validated['ara_id'] == $validated['ara_ara_id']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'An audit area cannot be its own parent',
                    ], 422);
                }

                // Check if the proposed parent would create a circular reference
                $parent = AuditArea::find($validated['ara_ara_id']);
                if ($parent && $this->wouldCreateCircularReference($validated['ara_id'], $validated['ara_ara_id'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This would create a circular reference',
                    ], 422);
                }
            }

            $auditArea = AuditArea::create($validated);

            // Load the relationship and transform
            $auditArea->load('parent', 'children');
            $transformedAuditArea = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parentId' => $auditArea->ara_ara_id,
                'parentName' => $auditArea->parent ? $auditArea->parent->ara_name : 'N/A',
                'active' => $auditArea->ara_active,
                'hasChildren' => $auditArea->children->count() > 0,
                'childrenCount' => $auditArea->children->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit area created successfully',
                'data' => $transformedAuditArea
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
                'message' => 'Failed to create audit area',
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
            $auditArea = AuditArea::with('parent', 'children')->findOrFail($id);

            $transformedAuditArea = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parentId' => $auditArea->ara_ara_id,
                'parentName' => $auditArea->parent ? $auditArea->parent->ara_name : 'N/A',
                'active' => $auditArea->ara_active,
                'hasChildren' => $auditArea->children->count() > 0,
                'childrenCount' => $auditArea->children->count(),
                'children' => $auditArea->children->map(function ($child) {
                    return [
                        'id' => $child->ara_id,
                        'name' => $child->ara_name,
                        'active' => $child->ara_active,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedAuditArea
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Audit area not found',
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
            $auditArea = AuditArea::findOrFail($id);

            $validated = $request->validate([
                'ara_name' => 'sometimes|required|string|max:255',
                'ara_ara_id' => 'sometimes|nullable|integer|min:0|max:127|exists:tblaudit_areas,ara_id',
                'ara_active' => 'sometimes|required|integer|in:0,1',
            ]);

            // Check for circular reference if parent is being updated
            if (isset($validated['ara_ara_id'])) {
                if ($id == $validated['ara_ara_id']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'An audit area cannot be its own parent',
                    ], 422);
                }

                // Check if the proposed parent would create a circular reference
                if (!empty($validated['ara_ara_id']) && $this->wouldCreateCircularReference($id, $validated['ara_ara_id'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This would create a circular reference',
                    ], 422);
                }
            }

            $auditArea->update($validated);

            // Load the relationship and transform
            $auditArea->load('parent', 'children');
            $transformedAuditArea = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parentId' => $auditArea->ara_ara_id,
                'parentName' => $auditArea->parent ? $auditArea->parent->ara_name : 'N/A',
                'active' => $auditArea->ara_active,
                'hasChildren' => $auditArea->children->count() > 0,
                'childrenCount' => $auditArea->children->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Audit area updated successfully',
                'data' => $transformedAuditArea
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
                'message' => 'Failed to update audit area',
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
            $auditArea = AuditArea::findOrFail($id);

            // Check if this audit area has children
            if ($auditArea->children()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete audit area with existing child areas. Please delete or reassign child areas first.',
                ], 422);
            }

            $auditArea->delete();

            return response()->json([
                'success' => true,
                'message' => 'Audit area deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete audit area',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if setting a parent would create a circular reference
     */
    private function wouldCreateCircularReference(int $childId, int $proposedParentId): bool
    {
        $currentParent = AuditArea::find($proposedParentId);

        while ($currentParent) {
            if ($currentParent->ara_id == $childId) {
                return true;  // Circular reference found
            }
            $currentParent = $currentParent->parent;
        }

        return false;
    }
}
