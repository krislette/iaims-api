<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $auditors = Auditor::with('agency')->get();

            // Transform data to match frontend format
            $transformedAuditors = $auditors->map(function ($auditor) {
                return [
                    'id' => $auditor->aur_id,
                    // Combine first, middle, and last names
                    'name' => trim($auditor->aur_name_first . ' ' . ($auditor->aur_name_middle ? $auditor->aur_name_middle . ' ' : '') . $auditor->aur_name_last),
                    'agency' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                    'position' => $auditor->aur_position,
                    'contactDetails' => $auditor->aur_contact_no, // Fixed: was looking for wrong field
                    'birthdate' => $auditor->aur_birthdate,
                    'expertise' => $auditor->aur_expertise,
                    'engagements' => $auditor->aur_engagements ?? 0,
                    'rating' => $auditor->aur_rating ?? 5,
                    'salaryGrade' => $auditor->aur_salary_grade,
                    'email' => $auditor->aur_email,
                    'tin' => $auditor->aur_tin,
                    'status' => $auditor->aur_status ? 'Active' : 'Inactive',
                    'isInternal' => !$auditor->aur_external, // Fixed: inverted logic since 0=internal, 1=external
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAuditors
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch auditors',
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
                'aur_id' => 'required|integer|unique:tblauditors,aur_id',
                'aur_name_first' => 'required|string|max:255',
                'aur_name_last' => 'required|string|max:255',
                'aur_name_middle' => 'nullable|string|max:255',
                'aur_position' => 'required|string|max:150',
                'aur_contact_no' => 'nullable|string',
                'aur_birthdate' => 'required|date',
                'aur_expertise' => 'nullable|string',
                'aur_salary_grade' => 'nullable|integer|min:1|max:33',
                'aur_email' => 'nullable|email|max:255',
                'aur_tin' => 'nullable|string|max:20',
                'aur_status' => 'nullable|boolean',
                'aur_external' => 'boolean',
                'aur_agn_id' => 'nullable|integer|exists:tblagencies,agn_id',
            ]);

            $auditor = Auditor::create($validated);
            $auditor->load('agency');

            $transformedAuditor = [
                'id' => $auditor->aur_id,
                'name' => trim($auditor->aur_name_first . ' ' . ($auditor->aur_name_middle ? $auditor->aur_name_middle . ' ' : '') . $auditor->aur_name_last),
                'agency' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'position' => $auditor->aur_position,
                'contactDetails' => $auditor->aur_contact_no,
                'birthdate' => $auditor->aur_birthdate,
                'expertise' => $auditor->aur_expertise,
                'engagements' => 0,
                'rating' => 5,
                'salaryGrade' => $auditor->aur_salary_grade,
                'email' => $auditor->aur_email,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status ? 'Active' : 'Inactive',
                'isInternal' => !$auditor->aur_external,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Auditor created successfully',
                'data' => $transformedAuditor
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
                'message' => 'Failed to create auditor',
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
            $auditor = Auditor::with('agency')->findOrFail($id);

            $transformedAuditor = [
                'id' => $auditor->aur_id,
                'name' => trim($auditor->aur_name_first . ' ' . ($auditor->aur_name_middle ? $auditor->aur_name_middle . ' ' : '') . $auditor->aur_name_last),
                'agency' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'position' => $auditor->aur_position,
                'contactDetails' => $auditor->aur_contact_no,
                'birthdate' => $auditor->aur_birthdate,
                'expertise' => $auditor->aur_expertise,
                'engagements' => 0,
                'rating' => 5,
                'salaryGrade' => $auditor->aur_salary_grade,
                'email' => $auditor->aur_email,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status ? 'Active' : 'Inactive',
                'isInternal' => !$auditor->aur_external,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedAuditor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Auditor not found',
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
            $auditor = Auditor::findOrFail($id);

            $validated = $request->validate([
                'aur_name_first' => 'sometimes|required|string|max:255',
                'aur_name_last' => 'sometimes|required|string|max:255',
                'aur_name_middle' => 'sometimes|nullable|string|max:255',
                'aur_position' => 'sometimes|required|string|max:150',
                'aur_contact_no' => 'sometimes|nullable|string',
                'aur_birthdate' => 'sometimes|required|date',
                'aur_expertise' => 'sometimes|nullable|string',
                'aur_salary_grade' => 'sometimes|nullable|integer|min:1|max:33',
                'aur_email' => 'sometimes|nullable|email|max:255',
                'aur_tin' => 'sometimes|nullable|string|max:20',
                'aur_status' => 'sometimes|nullable|boolean',
                'aur_external' => 'sometimes|boolean',
                'aur_agn_id' => 'sometimes|nullable|integer|exists:tblagencies,agn_id',
            ]);

            $auditor->update($validated);
            $auditor->load('agency');

            $transformedAuditor = [
                'id' => $auditor->aur_id,
                'name' => trim($auditor->aur_name_first . ' ' . ($auditor->aur_name_middle ? $auditor->aur_name_middle . ' ' : '') . $auditor->aur_name_last),
                'agency' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'position' => $auditor->aur_position,
                'contactDetails' => $auditor->aur_contact_no,
                'birthdate' => $auditor->aur_birthdate,
                'expertise' => $auditor->aur_expertise,
                'engagements' => 0,
                'rating' => 5,
                'salaryGrade' => $auditor->aur_salary_grade,
                'email' => $auditor->aur_email,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status ? 'Active' : 'Inactive',
                'isInternal' => !$auditor->aur_external,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Auditor updated successfully',
                'data' => $transformedAuditor
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
                'message' => 'Failed to update auditor',
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
            $auditor = Auditor::findOrFail($id);
            $auditor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Auditor deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete auditor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}