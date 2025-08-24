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
                    'lastName' => $auditor->aur_name_last,
                    'firstName' => $auditor->aur_name_first,
                    'middleName' => $auditor->aur_name_middle,
                    'namePrefix' => $auditor->aur_name_prefix,
                    'nameSuffix' => $auditor->aur_name_suffix,
                    'external' => $auditor->aur_external,
                    'position' => $auditor->aur_position,
                    'salaryGrade' => $auditor->aur_salary_grade,
                    'agencyId' => $auditor->aur_agn_id,
                    'agencyName' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                    'expertise' => $auditor->aur_expertise,
                    'email' => $auditor->aur_email,
                    'birthdate' => $auditor->aur_birthdate,
                    'contactNo' => $auditor->aur_contact_no,
                    'tin' => $auditor->aur_tin,
                    'status' => $auditor->aur_status,
                    'photo' => $auditor->aur_photo,
                    'active' => $auditor->aur_active,
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
                'aur_name_last' => 'required|string|max:50',
                'aur_name_first' => 'required|string|max:50',
                'aur_name_middle' => 'required|string|max:50',
                'aur_name_prefix' => 'required|string|max:20',
                'aur_name_suffix' => 'required|string|max:10',
                'aur_external' => 'required|integer|in:0,1',
                'aur_position' => 'nullable|string|max:150',
                'aur_salary_grade' => 'required|integer|min:1|max:127',
                'aur_agn_id' => 'nullable|integer|exists:tblagencies,agn_id',
                'aur_expertise' => 'nullable|string|max:255',
                'aur_email' => 'required|email|max:100',
                'aur_birthdate' => 'required|date',
                'aur_contact_no' => 'nullable|string|max:50',
                'aur_tin' => 'nullable|string|size:12',
                'aur_status' => 'required|integer|min:0|max:127',
                'aur_photo' => 'required|string|max:255',
                'aur_active' => 'required|integer|in:0,1',
            ]);

            $auditor = Auditor::create($validated);

            // Load the relationship and transform
            $auditor->load('agency');
            $transformedAuditor = [
                'id' => $auditor->aur_id,
                'lastName' => $auditor->aur_name_last,
                'firstName' => $auditor->aur_name_first,
                'middleName' => $auditor->aur_name_middle,
                'namePrefix' => $auditor->aur_name_prefix,
                'nameSuffix' => $auditor->aur_name_suffix,
                'external' => $auditor->aur_external,
                'position' => $auditor->aur_position,
                'salaryGrade' => $auditor->aur_salary_grade,
                'agencyId' => $auditor->aur_agn_id,
                'agencyName' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'expertise' => $auditor->aur_expertise,
                'email' => $auditor->aur_email,
                'birthdate' => $auditor->aur_birthdate,
                'contactNo' => $auditor->aur_contact_no,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status,
                'photo' => $auditor->aur_photo,
                'active' => $auditor->aur_active,
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
                'lastName' => $auditor->aur_name_last,
                'firstName' => $auditor->aur_name_first,
                'middleName' => $auditor->aur_name_middle,
                'namePrefix' => $auditor->aur_name_prefix,
                'nameSuffix' => $auditor->aur_name_suffix,
                'external' => $auditor->aur_external,
                'position' => $auditor->aur_position,
                'salaryGrade' => $auditor->aur_salary_grade,
                'agencyId' => $auditor->aur_agn_id,
                'agencyName' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'expertise' => $auditor->aur_expertise,
                'email' => $auditor->aur_email,
                'birthdate' => $auditor->aur_birthdate,
                'contactNo' => $auditor->aur_contact_no,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status,
                'photo' => $auditor->aur_photo,
                'active' => $auditor->aur_active,
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
                'aur_name_last' => 'sometimes|required|string|max:50',
                'aur_name_first' => 'sometimes|required|string|max:50',
                'aur_name_middle' => 'sometimes|required|string|max:50',
                'aur_name_prefix' => 'sometimes|required|string|max:20',
                'aur_name_suffix' => 'sometimes|required|string|max:10',
                'aur_external' => 'sometimes|required|integer|in:0,1',
                'aur_position' => 'sometimes|nullable|string|max:150',
                'aur_salary_grade' => 'sometimes|required|integer|min:1|max:127',
                'aur_agn_id' => 'sometimes|required|integer|exists:tblagencies,agn_id',
                'aur_expertise' => 'sometimes|nullable|string|max:255',
                'aur_email' => 'sometimes|required|email|max:100',
                'aur_birthdate' => 'sometimes|required|date',
                'aur_contact_no' => 'sometimes|nullable|string|max:50',
                'aur_tin' => 'sometimes|nullable|string|size:12',
                'aur_status' => 'sometimes|required|integer|min:0|max:127',
                'aur_photo' => 'sometimes|required|string|max:255',
                'aur_active' => 'sometimes|required|integer|in:0,1',
            ]);

            $auditor->update($validated);

            // Load the relationship and transform
            $auditor->load('agency');
            $transformedAuditor = [
                'id' => $auditor->aur_id,
                'lastName' => $auditor->aur_name_last,
                'firstName' => $auditor->aur_name_first,
                'middleName' => $auditor->aur_name_middle,
                'namePrefix' => $auditor->aur_name_prefix,
                'nameSuffix' => $auditor->aur_name_suffix,
                'external' => $auditor->aur_external,
                'position' => $auditor->aur_position,
                'salaryGrade' => $auditor->aur_salary_grade,
                'agencyId' => $auditor->aur_agn_id,
                'agencyName' => $auditor->agency ? $auditor->agency->agn_name : 'N/A',
                'expertise' => $auditor->aur_expertise,
                'email' => $auditor->aur_email,
                'birthdate' => $auditor->aur_birthdate,
                'contactNo' => $auditor->aur_contact_no,
                'tin' => $auditor->aur_tin,
                'status' => $auditor->aur_status,
                'photo' => $auditor->aur_photo,
                'active' => $auditor->aur_active,
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
