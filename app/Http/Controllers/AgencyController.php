<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $agencies = Agency::with('agencyGroup')->get();

            // Transform data to match frontend format
            $transformedAgencies = $agencies->map(function ($agency) {
                return [
                    'id' => $agency->agn_id,
                    'name' => $agency->agn_name,
                    'acronym' => $agency->agn_acronym,
                    'contactDetails' => $agency->agn_contact_details,
                    'headOfAgency' => $agency->agn_head_name,
                    'position' => $agency->agn_head_position,
                    'classificationGroup' => $agency->agencyGroup ? $agency->agencyGroup->agn_grp_name : 'N/A',
                    'address' => $agency->agn_address,
                    'groupCode' => $agency->agn_grp_code,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAgencies
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch agencies',
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
                'agn_name' => 'required|string|max:255',
                'agn_acronym' => 'nullable|string|max:30',
                'agn_grp_code' => 'nullable|string|size:2|exists:tblagency_groupings,agn_grp_code',
                'agn_address' => 'nullable|string|max:255',
                'agn_head_name' => 'nullable|string|max:150',
                'agn_head_position' => 'nullable|string|max:150',
                'agn_contact_details' => 'nullable|string',
            ]);

            $agency = Agency::create($validated);

            // Load the relationship and transform
            $agency->load('agencyGroup');
            $transformedAgency = [
                'id' => $agency->agn_id,
                'name' => $agency->agn_name,
                'acronym' => $agency->agn_acronym,
                'contactDetails' => $agency->agn_contact_details,
                'headOfAgency' => $agency->agn_head_name,
                'position' => $agency->agn_head_position,
                'classificationGroup' => $agency->agencyGroup ? $agency->agencyGroup->agn_grp_name : 'N/A',
                'address' => $agency->agn_address,
                'groupCode' => $agency->agn_grp_code,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Agency created successfully',
                'data' => $transformedAgency
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
                'message' => 'Failed to create agency',
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
            $agency = Agency::with('agencyGroup')->findOrFail($id);

            $transformedAgency = [
                'id' => $agency->agn_id,
                'name' => $agency->agn_name,
                'acronym' => $agency->agn_acronym,
                'contactDetails' => $agency->agn_contact_details,
                'headOfAgency' => $agency->agn_head_name,
                'position' => $agency->agn_head_position,
                'classificationGroup' => $agency->agencyGroup ? $agency->agencyGroup->agn_grp_name : 'N/A',
                'address' => $agency->agn_address,
                'groupCode' => $agency->agn_grp_code,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedAgency
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Agency not found',
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
            $agency = Agency::findOrFail($id);

            $validated = $request->validate([
                'agn_name' => 'sometimes|required|string|max:255',
                'agn_acronym' => 'sometimes|required|string|max:30',
                'agn_grp_code' => 'sometimes|required|string|size:2|exists:tblagency_groupings,agn_grp_code',
                'agn_address' => 'sometimes|required|string|max:255',
                'agn_head_name' => 'sometimes|required|string|max:150',
                'agn_head_position' => 'sometimes|required|string|max:150',
                'agn_contact_details' => 'sometimes|required|string',
            ]);

            $agency->update($validated);

            // Load the relationship and transform
            $agency->load('agencyGroup');
            $transformedAgency = [
                'id' => $agency->agn_id,
                'name' => $agency->agn_name,
                'acronym' => $agency->agn_acronym,
                'contactDetails' => $agency->agn_contact_details,
                'headOfAgency' => $agency->agn_head_name,
                'position' => $agency->agn_head_position,
                'classificationGroup' => $agency->agencyGroup ? $agency->agencyGroup->agn_grp_name : 'N/A',
                'address' => $agency->agn_address,
                'groupCode' => $agency->agn_grp_code,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Agency updated successfully',
                'data' => $transformedAgency
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
                'message' => 'Failed to update agency',
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
            $agency = Agency::findOrFail($id);
            $agency->delete();

            return response()->json([
                'success' => true,
                'message' => 'Agency deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete agency',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
