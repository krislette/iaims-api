<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'usr_name' => 'required|string|max:150',
            'usr_email' => 'required|string|email|max:100|unique:tbluser_accounts',
            'usr_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Generate unique IDs
            $auditorId = $this->generateUniqueId('tblauditors', 'aur_id');
            $userId = $this->generateUniqueId('tbluser_accounts', 'usr_id');

            // Parse name
            $nameParts = explode(' ', trim($request->usr_name), 3);
            $firstName = $nameParts[0] ?? '';
            $lastName = isset($nameParts[2]) ? $nameParts[2] : ($nameParts[1] ?? '');

            // Create Auditor with minimal data
            $auditor = Auditor::create([
                'aur_id' => $auditorId,
                'aur_name_last' => $lastName,
                'aur_name_first' => $firstName,
                'aur_name_middle' => $nameParts[1] ?? '',
                'aur_external' => 0,
                'aur_position' => null,  // Will be updated later via CRUD
                'aur_salary_grade' => 1,
                'aur_agn_id' => null,  // Will be updated later via CRUD
                'aur_expertise' => null,  // Will be updated later via CRUD
                'aur_email' => $request->usr_email,
                'aur_birthdate' => null,
                'aur_contact_no' => null,  // Will be updated later via CRUD
                'aur_tin' => null,  // Will be updated later via CRUD
                'aur_status' => 1,
                'aur_photo' => null,
                'aur_active' => 1,
            ]);

            // Create UserAccount
            $user = UserAccount::create([
                'usr_id' => $userId,
                'usr_name' => $request->usr_name,
                'usr_email' => $request->usr_email,
                'usr_password' => Hash::make($request->usr_password),
                'usr_active' => 1,
                'usr_logged' => 0,
                'usr_level' => 1,
                'usr_aur_id' => $auditor->aur_id,
            ]);

            DB::commit();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $token,
                'user' => $user,
                'auditor' => $auditor,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateUniqueId($table, $column)
    {
        do {
            $id = rand(10000, 99999);
        } while (DB::table($table)->where($column, $id)->exists());
        return $id;
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'usr_email' => 'required|string|email',
            'usr_password' => 'required|string|min:6',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        $user = UserAccount::where('usr_email', $request->usr_email)->first();

        if (!$user || !Hash::check($request->usr_password, $user->usr_password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user->usr_logged = 1;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->usr_logged = 0;
            $user->save();
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User has been logged out successfully.'
        ], 200);
    }
}
