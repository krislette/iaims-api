<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $documentTypes = DocumentType::all();

            // Transform data to match frontend format
            $transformedDocumentTypes = $documentTypes->map(function ($documentType) {
                return [
                    'id' => $documentType->doc_typ_id,
                    'name' => $documentType->doc_typ_name,
                    'active' => $documentType->doc_typ_active,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedDocumentTypes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch document types',
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
                'doc_typ_id' => 'required|integer|min:0|max:127|unique:tbldocument_types,doc_typ_id',
                'doc_typ_name' => 'required|string|max:100',
                'doc_typ_active' => 'required|integer|in:0,1',
            ]);

            $documentType = DocumentType::create($validated);

            $transformedDocumentType = [
                'id' => $documentType->doc_typ_id,
                'name' => $documentType->doc_typ_name,
                'active' => $documentType->doc_typ_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Document type created successfully',
                'data' => $transformedDocumentType
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
                'message' => 'Failed to create document type',
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
            $documentType = DocumentType::findOrFail($id);

            $transformedDocumentType = [
                'id' => $documentType->doc_typ_id,
                'name' => $documentType->doc_typ_name,
                'active' => $documentType->doc_typ_active,
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedDocumentType
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Document type not found',
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
            $documentType = DocumentType::findOrFail($id);

            $validated = $request->validate([
                'doc_typ_name' => 'sometimes|required|string|max:100',
                'doc_typ_active' => 'sometimes|required|integer|in:0,1',
            ]);

            $documentType->update($validated);

            $transformedDocumentType = [
                'id' => $documentType->doc_typ_id,
                'name' => $documentType->doc_typ_name,
                'active' => $documentType->doc_typ_active,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Document type updated successfully',
                'data' => $transformedDocumentType
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
                'message' => 'Failed to update document type',
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
            $documentType = DocumentType::findOrFail($id);
            $documentType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document type deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete document type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
