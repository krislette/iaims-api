<?php

namespace App\Http\Controllers;

use App\Models\AuditArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuditAreaController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $auditAreas = AuditArea::with(['parentAuditArea', 'childAuditAreas'])
                ->where('ara_active', 1)
                ->orderBy('ara_name')
                ->get();

            // Transform to match expected format
            $transformed = $auditAreas->map(function ($area) {
                return [
                    'id' => $area->ara_id,
                    'name' => $area->ara_name,
                    'parent_audit_area_id' => $area->ara_ara_id,
                    'active' => $area->ara_active,
                    'parent_audit_area' => $area->parentAuditArea ? [
                        'id' => $area->parentAuditArea->ara_id,
                        'name' => $area->parentAuditArea->ara_name,
                    ] : null,
                    'child_audit_areas' => $area->childAuditAreas->map(function ($child) {
                        return [
                            'id' => $child->ara_id,
                            'name' => $child->ara_name,
                        ];
                    }),
                    'created_at' => $area->created_at,
                    'updated_at' => $area->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch audit areas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'ara_name' => 'required|string|max:255|unique:tblaudit_areas,ara_name',
                'ara_ara_id' => 'nullable|integer|exists:tblaudit_areas,ara_id'
            ]);

            // Set default values
            $validated['ara_active'] = 1;

            // Prevent self-referencing and circular references
            if (isset($validated['ara_ara_id'])) {
                $parent = AuditArea::find($validated['ara_ara_id']);
                if ($parent) {
                    // Check for circular reference
                    $ancestors = collect([$parent]);
                    $current = $parent;
                    while ($current->parentAuditArea) {
                        $current = $current->parentAuditArea;
                        if ($ancestors->contains('ara_id', $current->ara_id)) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Circular reference detected'
                            ], 422);
                        }
                        $ancestors->push($current);
                    }
                }
            }

            $auditArea = AuditArea::create($validated);
            $auditArea->load(['parentAuditArea', 'childAuditAreas']);

            // Transform response
            $transformed = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parent_audit_area_id' => $auditArea->ara_ara_id,
                'active' => $auditArea->ara_active,
                'parent_audit_area' => $auditArea->parentAuditArea ? [
                    'id' => $auditArea->parentAuditArea->ara_id,
                    'name' => $auditArea->parentAuditArea->ara_name,
                ] : null,
                'child_audit_areas' => $auditArea->childAuditAreas->map(function ($child) {
                    return [
                        'id' => $child->ara_id,
                        'name' => $child->ara_name,
                    ];
                }),
                'created_at' => $auditArea->created_at,
                'updated_at' => $auditArea->updated_at,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformed,
                'message' => 'Audit area created successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
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

    public function show($id): JsonResponse
    {
        try {
            $auditArea = AuditArea::with(['parentAuditArea', 'childAuditAreas'])
                ->where('ara_id', $id)
                ->where('ara_active', 1)
                ->first();

            if (!$auditArea) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audit area not found'
                ], 404);
            }

            // Transform response
            $transformed = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parent_audit_area_id' => $auditArea->ara_ara_id,
                'active' => $auditArea->ara_active,
                'parent_audit_area' => $auditArea->parentAuditArea ? [
                    'id' => $auditArea->parentAuditArea->ara_id,
                    'name' => $auditArea->parentAuditArea->ara_name,
                ] : null,
                'child_audit_areas' => $auditArea->childAuditAreas->map(function ($child) {
                    return [
                        'id' => $child->ara_id,
                        'name' => $child->ara_name,
                    ];
                }),
                'created_at' => $auditArea->created_at,
                'updated_at' => $auditArea->updated_at,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch audit area',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $auditArea = AuditArea::where('ara_id', $id)->where('ara_active', 1)->first();

            if (!$auditArea) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audit area not found'
                ], 404);
            }

            $validated = $request->validate([
                'ara_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tblaudit_areas', 'ara_name')->ignore($auditArea->ara_id, 'ara_id')
                ],
                'ara_ara_id' => 'nullable|integer|exists:tblaudit_areas,ara_id'
            ]);

            // Prevent self-referencing
            if (isset($validated['ara_ara_id'])) {
                if ($validated['ara_ara_id'] == $auditArea->ara_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Audit area cannot be its own parent'
                    ], 422);
                }

                // Check if the new parent would create a circular reference
                $parent = AuditArea::find($validated['ara_ara_id']);
                if ($parent) {
                    $descendants = $auditArea->getAllDescendants();
                    if ($descendants->contains('ara_id', $parent->ara_id)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot set a descendant as parent'
                        ], 422);
                    }
                }
            }

            $auditArea->update($validated);
            $auditArea->load(['parentAuditArea', 'childAuditAreas']);

            // Transform response
            $transformed = [
                'id' => $auditArea->ara_id,
                'name' => $auditArea->ara_name,
                'parent_audit_area_id' => $auditArea->ara_ara_id,
                'active' => $auditArea->ara_active,
                'parent_audit_area' => $auditArea->parentAuditArea ? [
                    'id' => $auditArea->parentAuditArea->ara_id,
                    'name' => $auditArea->parentAuditArea->ara_name,
                ] : null,
                'child_audit_areas' => $auditArea->childAuditAreas->map(function ($child) {
                    return [
                        'id' => $child->ara_id,
                        'name' => $child->ara_name,
                    ];
                }),
                'created_at' => $auditArea->created_at,
                'updated_at' => $auditArea->updated_at,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformed,
                'message' => 'Audit area updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
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

    public function destroy($id): JsonResponse
    {
        try {
            $auditArea = AuditArea::where('ara_id', $id)->where('ara_active', 1)->first();

            if (!$auditArea) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audit area not found'
                ], 404);
            }

            // Check if audit area has children
            if ($auditArea->childAuditAreas()->where('ara_active', 1)->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete audit area with sub-audit areas. Please delete sub-audit areas first.'
                ], 422);
            }

            // Soft delete by setting ara_active to 0
            $auditArea->update(['ara_active' => 0]);

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

    public function getParentOptions(): JsonResponse
    {
        try {
            $parentOptions = AuditArea::select('ara_id', 'ara_name', 'ara_ara_id')
                ->where('ara_active', 1)
                ->orderBy('ara_name')
                ->get()
                ->map(function ($area) {
                    return [
                        'id' => $area->ara_id,
                        'name' => $area->ara_name,
                        'parent_audit_area_id' => $area->ara_ara_id,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $parentOptions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch parent options',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
