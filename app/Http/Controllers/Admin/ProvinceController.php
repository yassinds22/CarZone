<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProvinceRequest;
use App\Services\ProvinceService;
use Illuminate\Http\Request;

/**
 * @group Provinces Management
 *
 * APIs for managing provinces in the system.
 */
class ProvinceController extends Controller
{
    protected $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        $this->provinceService = $provinceService;
    }

    /**
     * Get a list of all provinces.
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Sana'a",
     *       "parent_id": 0,
     *       "created_at": "2025-10-13T14:36:35.000000Z",
     *       "updated_at": "2025-10-13T14:36:35.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return $this->provinceService->getAll();
    }

    /**
     * Create a new province.
     *
     * @bodyParam name string required The name of the province. Example: Sana'a
     * @bodyParam parent_id integer optional The ID of the parent province. Example: 0
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Province created successfully.",
     *   "data": {
     *       "id": 1,
     *       "name": "Sana'a",
     *       "parent_id": 0,
     *       "created_at": "2025-10-13T14:36:35.000000Z",
     *       "updated_at": "2025-10-13T14:36:35.000000Z"
     *   }
     * }
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to create province: [error message]"
     * }
     */
    public function store(StoreProvinceRequest $request)
    {
        try {
            $province = $this->provinceService->saveProvince($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Province created successfully.',
                'data' => $province
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create province: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific province by ID.
     *
     * @urlParam id integer required The ID of the province. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *       "id": 1,
     *       "name": "Sana'a",
     *       "parent_id": 0,
     *       "created_at": "2025-10-13T14:36:35.000000Z",
     *       "updated_at": "2025-10-13T14:36:35.000000Z"
     *   }
     * }
     * @response 404 {
     *   "success": false,
     *   "message": "Province not found."
     * }
     */
    public function show(string $id)
    {
        return $this->provinceService->getById($id);
    }

    /**
     * Update an existing province.
     *
     * @urlParam id integer required The ID of the province to update.
     * @bodyParam name string required The updated name of the province. Example: Aden
     * @bodyParam parent_id integer optional The parent province ID. Example: 0
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Province updated successfully.",
     *   "data": {
     *       "id": 1,
     *       "name": "Aden",
     *       "parent_id": 0,
     *       "updated_at": "2025-10-13T17:22:00.000000Z",
     *       "created_at": "2025-10-13T14:36:35.000000Z"
     *   }
     * }
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to update province: Record not found"
     * }
     */
    public function update(StoreProvinceRequest $storeProvinceRequest, $id)
    {
        try {
            $province = $this->provinceService->updateProvince($id, $storeProvinceRequest->validated());

            return response()->json([
                'success' => true,
                'message' => 'Province updated successfully.',
                'data' => $province
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update province: ' . $e->getMessage()
            ], 500);
        }
    }

 /**
 * Delete a province by ID.
 *
 * @urlParam id integer required The ID of the province to delete. Example: 1
 *
 * @response 200 {
 *   "success": true,
 *   "message": "Province deleted successfully."
 * }
 * @response 404 {
 *   "success": false,
 *   "message": "Province not found."
 * }
 * @response 500 {
 *   "success": false,
 *   "message": "Failed to delete province: [error message]"
 * }
 */
public function destroy($id)
{
    try {
        $this->provinceService->deleteProvinceById($id);

        return response()->json([
            'success' => true,
            'message' => 'Province deleted successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete province: ' . $e->getMessage()
        ], 500);
    }
}

}
