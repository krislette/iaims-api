<?php

namespace App\Http\Controllers;

use App\Models\InternalControl;
use App\Models\InternalControlComponent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InternalControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $internalControls = InternalControl::with(['auditArea', 'components'])->get();

            // Transform data to match frontend format
            $transformedInternalControls = $internalControls->map(function ($control) {
                return [
                    'id' => $control->ic_id,
                    'auditAreaId' => $control->ic_ara_id,
                    'auditAreaName' => $control->auditArea ? $control->auditArea->ara_name : 'N/A',
                    'category' => $control->ic_category,
                    'description' => $control->ic_desc,
                    'active' => $control->ic_active,
                    'componentsCount' => $control->components->count(),
                    'components' => $control->components->map(function ($component) {
                        return [
                            'sequenceNumber' => $component->com_seqnum,
                            'description' => $component->com_desc,
                        ];
                    }),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedInternalControls
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch internal controls',
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
                'ic_ara_id' => 'required|integer|min:0|max:127|exists:tblaudit_areas,ara_id',
                'ic_category' => 'required|string|max:100',
                'ic_desc' => 'required|string|max:500',
                'ic_active' => 'required|integer|in:0,1',
                'components' => 'sometimes|array',
                'components.*.com_seqnum' => 'required_with:components|integer|min:0|max:127',
                'components.*.com_desc' => 'required_with:components|string|max:300',
            ]);

            DB::beginTransaction();

            $internalControl = InternalControl::create([
                'ic_ara_id' => $validated['ic_ara_id'],
                'ic_category' => $validated['ic_category'],
                'ic_desc' => $validated['ic_desc'],
                'ic_active' => $validated['ic_active'],
            ]);

            // Create components if provided
            if (!empty($validated['components'])) {
                foreach ($validated['components'] as $componentData) {
                    InternalControlComponent::create([
                        'com_ic_id' => $internalControl->ic_id,
                        'com_seqnum' => $componentData['com_seqnum'],
                        'com_desc' => $componentData['com_desc'],
                    ]);
                }
            }

            DB::commit();

            // Load the relationships and transform
            $internalControl->load(['auditArea', 'components']);
            $transformedInternalControl = [
                'id' => $internalControl->ic_id,
                'auditAreaId' => $internalControl->ic_ara_id,
                'auditAreaName' => $internalControl->auditArea ? $internalControl->auditArea->ara_name : 'N/A',
                'category' => $internalControl->ic_category,
                'description' => $internalControl->ic_desc,
                'active' => $internalControl->ic_active,
                'componentsCount' => $internalControl->components->count(),
                'components' => $internalControl->components->map(function ($component) {
                    return [
                        'sequenceNumber' => $component->com_seqnum,
                        'description' => $component->com_desc,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Internal control created successfully',
                'data' => $transformedInternalControl
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create internal control',
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
            $internalControl = InternalControl::with(['auditArea', 'components'])->findOrFail($id);

            $transformedInternalControl = [
                'id' => $internalControl->ic_id,
                'auditAreaId' => $internalControl->ic_ara_id,
                'auditAreaName' => $internalControl->auditArea ? $internalControl->auditArea->ara_name : 'N/A',
                'category' => $internalControl->ic_category,
                'description' => $internalControl->ic_desc,
                'active' => $internalControl->ic_active,
                'componentsCount' => $internalControl->components->count(),
                'components' => $internalControl->components->map(function ($component) {
                    return [
                        'sequenceNumber' => $component->com_seqnum,
                        'description' => $component->com_desc,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedInternalControl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal control not found',
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
            $internalControl = InternalControl::findOrFail($id);

            $validated = $request->validate([
                'ic_ara_id' => 'sometimes|required|integer|min:0|max:127|exists:tblaudit_areas,ara_id',
                'ic_category' => 'sometimes|required|string|max:100',
                'ic_desc' => 'sometimes|required|string|max:500',
                'ic_active' => 'sometimes|required|integer|in:0,1',
                'components' => 'sometimes|array',
                'components.*.com_seqnum' => 'required_with:components|integer|min:0|max:127',
                'components.*.com_desc' => 'required_with:components|string|max:300',
            ]);

            DB::beginTransaction();

            $internalControl->update([
                'ic_ara_id' => $validated['ic_ara_id'] ?? $internalControl->ic_ara_id,
                'ic_category' => $validated['ic_category'] ?? $internalControl->ic_category,
                'ic_desc' => $validated['ic_desc'] ?? $internalControl->ic_desc,
                'ic_active' => $validated['ic_active'] ?? $internalControl->ic_active,
            ]);

            // Update components if provided
            if (isset($validated['components'])) {
                // Delete existing components
                InternalControlComponent::where('com_ic_id', $internalControl->ic_id)->delete();

                // Create new components
                foreach ($validated['components'] as $componentData) {
                    InternalControlComponent::create([
                        'com_ic_id' => $internalControl->ic_id,
                        'com_seqnum' => $componentData['com_seqnum'],
                        'com_desc' => $componentData['com_desc'],
                    ]);
                }
            }

            DB::commit();

            // Load the relationships and transform
            $internalControl->load(['auditArea', 'components']);
            $transformedInternalControl = [
                'id' => $internalControl->ic_id,
                'auditAreaId' => $internalControl->ic_ara_id,
                'auditAreaName' => $internalControl->auditArea ? $internalControl->auditArea->ara_name : 'N/A',
                'category' => $internalControl->ic_category,
                'description' => $internalControl->ic_desc,
                'active' => $internalControl->ic_active,
                'componentsCount' => $internalControl->components->count(),
                'components' => $internalControl->components->map(function ($component) {
                    return [
                        'sequenceNumber' => $component->com_seqnum,
                        'description' => $component->com_desc,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Internal control updated successfully',
                'data' => $transformedInternalControl
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update internal control',
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
            DB::beginTransaction();

            $internalControl = InternalControl::findOrFail($id);

            // Delete related components first
            InternalControlComponent::where('com_ic_id', $internalControl->ic_id)->delete();

            // Delete the internal control
            $internalControl->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Internal control deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete internal control',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
