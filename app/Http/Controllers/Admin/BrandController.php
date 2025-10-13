<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;

/**
 * @group Brand Management
 *
 * APIs for managing brands in the system.
 */
class BrandController extends Controller
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Get all brands
     *
     * Retrieve a list of all brands.
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Toyota",
     *       "created_at": "2025-10-13T14:36:35.000000Z",
     *       "updated_at": "2025-10-13T14:36:35.000000Z",
     *       "media": [
     *         {
     *           "url": "http://127.0.0.1:8000/storage/brands/1634567890_image.png"
     *         }
     *       ]
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return $this->brandService->getAll();
    }

    /**
     * Store a new brand
     *
     * Create a new brand with optional image upload.
     *
     * @bodyParam name string required The name of the brand. Example: Toyota
     * @bodyParam image file optional The image file of the brand.
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Brand created successfully.",
     *   "data": {
     *     "id": 1,
     *     "name": "Toyota",
     *     "created_at": "2025-10-13T14:36:35.000000Z",
     *     "updated_at": "2025-10-13T14:36:35.000000Z",
     *     "media": [
     *       {
     *         "url": "http://127.0.0.1:8000/storage/brands/1634567890_image.png"
     *       }
     *     ]
     *   }
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to create brand: [error message]"
     * }
     */
    public function store(StoreBrandRequest $request)
    {
        return $this->brandService->saveBrand($request->validated(), $request->file('image'));
    }

    /**
     * Show brand details
     *
     * Display a specific brand by ID.
     *
     * @urlParam id integer required The ID of the brand.
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Toyota",
     *   "created_at": "2025-10-13T14:36:35.000000Z",
     *   "updated_at": "2025-10-13T14:36:35.000000Z",
     *   "media": [
     *     {
     *       "url": "http://127.0.0.1:8000/storage/brands/1634567890_image.png"
     *     }
     *   ]
     * }
     */
    public function show(int $id)
    {
        return $this->brandService->getById($id);
    }

    /**
     * Update brand
     *
     * Update an existing brand with optional image replacement.
     *
     * @urlParam id integer required The ID of the brand.
     * @bodyParam name string required The updated name of the brand. Example: Toyota Updated
     * @bodyParam image file optional The updated image of the brand.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Brand updated successfully.",
     *   "data": {
     *     "id": 1,
     *     "name": "Toyota Updated",
     *     "created_at": "2025-10-13T14:36:35.000000Z",
     *     "updated_at": "2025-10-13T17:22:00.000000Z",
     *     "media": [
     *       {
     *         "url": "http://127.0.0.1:8000/storage/brands/1634567890_new_image.png"
     *       }
     *     ]
     *   }
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to update brand: [error message]"
     * }
     */
    public function update(StoreBrandRequest $request, int $id)
    {
        try {
            $brand = $this->brandService->updateBrand($id, $request->validated(), $request->file('image'));

            return response()->json([
                'success' => true,
                'message' => 'Brand updated successfully.',
                'data' => $brand
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update brand: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete brand
     *
     * Remove a brand by ID.
     *
     * @urlParam id integer required The ID of the brand.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Brand deleted successfully."
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to delete brand: [error message]"
     * }
     */
    public function destroy(int $id)
    {
        try {
            $this->brandService->deleteBrandById($id);

            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete brand: ' . $e->getMessage()
            ], 500);
        }
    }
}
