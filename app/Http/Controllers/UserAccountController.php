<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            // Load auditor and agency relationships
            $userAccounts = UserAccount::with('auditor.agency')->get();

            // Transform data to match frontend format
            $transformedUserAccounts = $userAccounts->map(function ($user) {
                return [
                    'id' => $user->usr_id,
                    'name' => $user->usr_name,
                    'auditorId' => $user->usr_aur_id,
                    'auditorName' => $user->auditor
                        ? $user->auditor->aur_name_last . ', ' . $user->auditor->aur_name_first
                        : 'N/A',
                    'level' => $user->usr_level,
                    'levelName' => $user->user_level_name,
                    'email' => $user->usr_email,
                    'active' => $user->usr_active,
                    'logged' => $user->usr_logged,
                    'agencyName' => $user->auditor && $user->auditor->agency
                        ? $user->auditor->agency->agn_name
                        : 'N/A',
                    'agencyAcronym' => $user->auditor && $user->auditor->agency
                        ? $user->auditor->agency->agn_acronym
                        : 'N/A',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedUserAccounts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user accounts',
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
                'usr_name' => 'required|string|max:150',
                'usr_aur_id' => 'required|integer|exists:tblauditors,aur_id',
                'usr_level' => 'required|integer|min:1|max:127',
                'usr_email' => 'required|email|max:100|unique:tbluser_accounts,usr_email',
                'usr_password' => 'required|string|min:6',
                'usr_active' => 'required|integer|in:0,1',
                'usr_logged' => 'sometimes|integer|in:0,1',
            ]);

            // Set default logged status if not provided
            $validated['usr_logged'] = $validated['usr_logged'] ?? 0;

            // Hash password if not hashed
            if (isset($validated['usr_password'])) {
                $validated['usr_password'] = Hash::make($validated['usr_password']);
            }

            $userAccount = UserAccount::create($validated);

            // Load the relationships and transform
            $userAccount->load('auditor.agency');
            $transformedUserAccount = [
                'id' => $userAccount->usr_id,
                'name' => $userAccount->usr_name,
                'auditorId' => $userAccount->usr_aur_id,
                'auditorName' => $userAccount->auditor
                    ? $userAccount->auditor->aur_name_last . ', ' . $userAccount->auditor->aur_name_first
                    : 'N/A',
                'level' => $userAccount->usr_level,
                'levelName' => $userAccount->user_level_name,
                'email' => $userAccount->usr_email,
                'active' => $userAccount->usr_active,
                'logged' => $userAccount->usr_logged,
                'agencyName' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_name
                    : 'N/A',
                'agencyAcronym' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_acronym
                    : 'N/A',
            ];

            return response()->json([
                'success' => true,
                'message' => 'User account created successfully',
                'data' => $transformedUserAccount
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
                'message' => 'Failed to create user account',
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
            $userAccount = UserAccount::with('auditor.agency')->findOrFail($id);

            // Load the relationships and transform
            $userAccount->load('auditor.agency');
            $transformedUserAccount = [
                'id' => $userAccount->usr_id,
                'name' => $userAccount->usr_name,
                'auditorId' => $userAccount->usr_aur_id,
                'auditorName' => $userAccount->auditor
                    ? $userAccount->auditor->aur_name_last . ', ' . $userAccount->auditor->aur_name_first
                    : 'N/A',
                'level' => $userAccount->usr_level,
                'levelName' => $userAccount->user_level_name,
                'email' => $userAccount->usr_email,
                'active' => $userAccount->usr_active,
                'logged' => $userAccount->usr_logged,
                'agencyName' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_name
                    : 'N/A',
                'agencyAcronym' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_acronym
                    : 'N/A',
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedUserAccount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User account not found',
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
            $userAccount = UserAccount::findOrFail($id);

            $validated = $request->validate([
                'usr_name' => 'sometimes|required|string|max:150',
                'usr_aur_id' => 'sometimes|required|integer|exists:tblauditors,aur_id',
                'usr_level' => 'sometimes|required|integer|min:1|max:127',
                'usr_email' => 'sometimes|required|email|max:100|unique:tbluser_accounts,usr_email,' . $id . ',usr_id',
                'usr_password' => 'sometimes|string|min:6',
                'usr_active' => 'sometimes|required|integer|in:0,1',
                'usr_logged' => 'sometimes|required|integer|in:0,1',
            ]);

            // Hash password if it's being updated
            if (isset($validated['usr_password'])) {
                $validated['usr_password'] = Hash::make($validated['usr_password']);
            }

            $userAccount->update($validated);

            // Load the relationships and transform
            $userAccount->load('auditor.agency');
            $transformedUserAccount = [
                'id' => $userAccount->usr_id,
                'name' => $userAccount->usr_name,
                'auditorId' => $userAccount->usr_aur_id,
                'auditorName' => $userAccount->auditor
                    ? $userAccount->auditor->aur_name_last . ', ' . $userAccount->auditor->aur_name_first
                    : 'N/A',
                'level' => $userAccount->usr_level,
                'levelName' => $userAccount->user_level_name,
                'email' => $userAccount->usr_email,
                'active' => $userAccount->usr_active,
                'logged' => $userAccount->usr_logged,
                'agencyName' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_name
                    : 'N/A',
                'agencyAcronym' => $userAccount->auditor && $userAccount->auditor->agency
                    ? $userAccount->auditor->agency->agn_acronym
                    : 'N/A',
            ];

            return response()->json([
                'success' => true,
                'message' => 'User account updated successfully',
                'data' => $transformedUserAccount
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
                'message' => 'Failed to update user account',
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
            $userAccount = UserAccount::findOrFail($id);
            $userAccount->delete();

            return response()->json([
                'success' => true,
                'message' => 'User account deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request, int $id): JsonResponse
    {
        try {
            $userAccount = UserAccount::findOrFail($id);

            $validated = $request->validate([
                'current_password' => 'sometimes|required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            // Verify current password if provided
            if (isset($validated['current_password'])) {
                if (!Hash::check($validated['current_password'], $userAccount->usr_password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect',
                    ], 422);
                }
            }

            // Hash the new password before saving
            $userAccount->usr_password = Hash::make($validated['new_password']);
            $userAccount->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
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
                'message' => 'Failed to change password',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
