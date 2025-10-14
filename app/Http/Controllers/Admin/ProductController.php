<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * @group Products Management
 *
 * APIs for managing car products (Cars for sale).
 */
class ProductController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * Get All Products
     *
     * Retrieve a list of all products (cars) in the system.
     *
     * @response 200 {
     *  "success": true,
     *  "data": [
     *      {
     *          "id": 1,
     *          "title": "Toyota Corolla",
     *          "description": "A reliable and efficient car",
     *          "model_car": "2024",
     *          "price": "25000.00",
     *          "car_status": "جديدة",
     *          "engine_number": "6",
     *          "fuel_type": "بترول",
     *          "latitude": "15.3694",
     *          "longitude": "44.1910",
     *          "brand_id": 1,
     *          "province_id": 2,
     *          "created_at": "2025-10-13T14:36:35.000000Z",
     *          "updated_at": "2025-10-13T14:36:35.000000Z"
     *      }
     *  ]
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to fetch products: [error message]"
     * }
     */
    public function index()
    {
        try {
            $products = $this->productService->getAll();
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create New Product
     *
     * Create a new product with car details and two images.
     *
     * @bodyParam title string required The product title. Example: Toyota Corolla
     * @bodyParam description string required The product description. Example: A reliable and fuel-efficient car.
     * @bodyParam model_car string required The model name or number. Example: 2024 XLE
     * @bodyParam price decimal required The price of the product. Example: 25000.00
     * @bodyParam car_status string required The status of the car. Example: جديدة
     * @bodyParam engine_number string required Engine type (4, 6, 8). Example: 6
     * @bodyParam fuel_type string required Fuel type (ديزل، بترول، كهرباء، هجين). Example: بترول
     * @bodyParam latitude string optional The latitude for map location. Example: 15.3694
     * @bodyParam longitude string optional The longitude for map location. Example: 44.1910
     * @bodyParam brand_id integer required The brand ID. Example: 1
     * @bodyParam province_id integer required The province ID. Example: 2
     * @bodyParam image1 file required The main car image.
     * @bodyParam image2 file optional The secondary image for the car.
     *
     * @response 201 {
     *  "success": true,
     *  "message": "Product created successfully.",
     *  "data": {
     *      "id": 1,
     *      "title": "Toyota Corolla",
     *      "price": "25000.00",
     *      "car_status": "جديدة",
     *      "engine_number": "6",
     *      "fuel_type": "بترول",
     *      "image1_url": "http://127.0.0.1:8000/storage/products/1/main.jpg",
     *      "image2_url": "http://127.0.0.1:8000/storage/products/1/extra.jpg",
     *      "created_at": "2025-10-13T14:36:35.000000Z"
     *  }
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to create product: [error message]"
     * }
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->saveProduct(
                $request->validated(),
                $request->file('image1'),
                $request->file('image2')
            );

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Single Product
     *
     * Retrieve a single product by its ID.
     *
     * @urlParam id integer required The ID of the product. Example: 1
     *
     * @response 200 {
     *  "success": true,
     *  "data": {
     *      "id": 1,
     *      "title": "Toyota Corolla",
     *      "description": "Reliable car",
     *      "price": "25000.00"
     *  }
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Product not found"
     * }
     */
    public function show(string $id)
    {
        try {
            $product = $this->productService->getById($id);
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update Product
     *
     * Update an existing product's details or images.
     *
     * @urlParam id integer required The ID of the product to update. Example: 1
     * @bodyParam title string optional The new title. Example: Toyota Camry
     * @bodyParam price decimal optional The new price. Example: 27000.00
     * @bodyParam image1 file optional The new main image.
     * @bodyParam image2 file optional The new secondary image.
     *
     * @response 200 {
     *  "success": true,
     *  "message": "Product updated successfully.",
     *  "data": {
     *      "id": 1,
     *      "title": "Toyota Camry",
     *      "price": "27000.00",
     *      "updated_at": "2025-10-14T10:00:00Z"
     *  }
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to update product: [error message]"
     * }
     */
    public function update(StoreProductRequest $request, string $id)
    {
        try {
            $product = $this->productService->updateProduct(
                $id,
                $request->validated(),
                $request->file('image1'),
                $request->file('image2')
            );

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Product
     *
     * Delete a product by its ID.
     *
     * @urlParam id integer required The ID of the product to delete. Example: 1
     *
     * @response 200 {
     *  "success": true,
     *  "message": "Product deleted successfully."
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to delete product: [error message]"
     * }
     */
    public function destroy(string $id)
    {
        try {
            $this->productService->deleteProductById($id);
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }
}
