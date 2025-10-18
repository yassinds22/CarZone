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

}
