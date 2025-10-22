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
     * Each product includes main_image_url and sub_image_url for the associated images.
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
     *          "updated_at": "2025-10-13T14:36:35.000000Z",
     *          "main_image_url": "http://example.com/storage/products/main_image.jpg",
     *          "sub_image_url": "http://example.com/storage/products/sub_image.jpg"
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

        // نضيف روابط الصور إلى كل منتج
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'model' => $product->model,
                'price' => $product->price,
                'condition' => $product->condition,
                'engine_cylinders' => $product->engine_cylinders,
                'fuel_type' => $product->fuel_type,
                'latitude' => $product->latitude,
                'longitude' => $product->longitude,
                'brand_id' => $product->brand_id,
                'province_id' => $product->province_id,
                'user_id' => $product->user_id,

                // روابط الصور من Spatie Media Library
                'images' => [
                    'main_image' => $product->getFirstMediaUrl('main_image'),
                    'sub_image' => $product->getFirstMediaUrl('sub_image'),
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch products: ' . $e->getMessage(),
        ], 500);
    }
}


   /**
     * Create New Product
     *
     * @group Products Management
     * @authenticated
     *
     * @bodyParam title string required The product title. Example: Toyota Corolla
     * @bodyParam description string required The product description. Example: A reliable and fuel-efficient car.
     * @bodyParam model_car string required The model year or name. Example: 2024 XLE
     * @bodyParam price decimal required Product price. Example: 25000.00
     * @bodyParam car_status string required Car condition. Example: جديدة
     * @bodyParam engine_number string required Engine type. Example: 6
     * @bodyParam fuel_type string required Fuel type. Example: بترول
     * @bodyParam latitude string optional Latitude for map location. Example: 15.3694
     * @bodyParam longitude string optional Longitude for map location. Example: 44.1910
     * @bodyParam brand_id integer required Brand ID. Example: 1
     * @bodyParam province_id integer required Province ID. Example: 2
     * @bodyParam image1 file required Main image
     * @bodyParam image2 file optional Secondary image
     *
     * @response 201 {
     *  "success": true,
     *  "message": "Product created successfully.",
     *  "data": { ... }
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to create product: [error message]"
     * }
     */
   public function store(StoreProductRequest $request)
{
    try {
        // إنشاء المنتج وتخزين الصور عبر الـ Service
        $product = $this->productService->saveProduct(
            $request->validated(),
            $request->file('main_image'),
            $request->file('sub_image')
        );

        // تجهيز روابط الصور من Spatie Media Library
        $main_image = $product->getFirstMediaUrl('main_image');
        $sub_image = $product->getFirstMediaUrl('sub_image');

        // إرسال الرد بنجاح
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data' => [
                'product' => $product,
                'images' => [
                    'main_image' => $main_image,
                    'sub_image' => $sub_image,
                ],
            ],
        ], 201);

    } catch (\Exception $e) {
        // التعامل مع أي أخطاء أثناء العملية
        return response()->json([
            'success' => false,
            'message' => 'Failed to create product: ' . $e->getMessage(),
        ], 500);
    }
}


    /**
     * Update Product
     *
     * @group Products Management
     * @authenticated
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
        // تحديث المنتج
        $product = $this->productService->updateProduct(
            $id,
            $request->validated(),
            $request->hasFile('main_image') ? $request->file('main_image') : null,
            $request->hasFile('sub_image') ? $request->file('sub_image') : null
        );

        // تجهيز روابط الصور من Spatie Media Library
        $main_image = $product->getFirstMediaUrl('main_image');
        $sub_image = $product->getFirstMediaUrl('sub_image');

        // إرسال الرد النهائي
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'data' => [
                'product' => $product,
                'images' => [
                    'main_image' => $main_image ?: null,
                    'sub_image' => $sub_image ?: null,
                ],
            ],
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update product: ' . $e->getMessage()
        ], 500);
    }
}


   /**
     * Show Product
     *
     * Retrieve a single product by its ID.
     * Includes main_image_url and sub_image_url for the associated images.
     *
     * @urlParam id integer required The ID of the product. Example: 1
     *
     * @response 200 {
     *  "success": true,
     *  "data": {
     *      "id": 1,
     *      "title": "Toyota Corolla",
     *      "description": "A reliable and efficient car",
     *      "model_car": "2024",
     *      "price": "25000.00",
     *      "main_image_url": "http://example.com/storage/products/main_image.jpg",
     *      "sub_image_url": "http://example.com/storage/products/sub_image.jpg"
     *  }
     * }
     * @response 404 {
     *  "success": false,
     *  "message": "Product not found"
     * }
     * @response 500 {
     *  "success": false,
     *  "message": "Failed to fetch product: [error message]"
     * }
     */
    public function show($id)
    {
        try {
            $product = $this->productService->getById($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // إضافة روابط الصور مباشرة
            $product->main_image_url = $product->getFirstMediaUrl('main_image');
            $product->sub_image_url  = $product->getFirstMediaUrl('sub_image');

            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Product
     *
     * @group Products Management
     * @authenticated
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
