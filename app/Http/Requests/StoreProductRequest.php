<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'model_car' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'car_status' => 'required|string',
            'engine_number' => 'required|string',
            'fuel_type' => 'required|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'province_id' => 'required|exists:provinces,id',
            'user_id' => 'required|exists:users,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sub_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get body parameters for API documentation
     */
    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'The product title',
                'example' => 'Toyota Corolla 2024'
            ],
            'description' => [
                'description' => 'The product description',
                'example' => 'A reliable and fuel-efficient car with modern features.'
            ],
            'model_car' => [
                'description' => 'The model name or number',
                'example' => '2024 XLE'
            ],
            'price' => [
                'description' => 'The price of the product',
                'example' => 25000.00
            ],
            'car_status' => [
                'description' => 'The status of the car',
                'example' => 'جديدة'
            ],
            'engine_number' => [
                'description' => 'Engine type (4, 6, 8)',
                'example' => '6'
            ],
            'fuel_type' => [
                'description' => 'Fuel type',
                'example' => 'بترول'
            ],
            'latitude' => [
                'description' => 'The latitude for map location',
                'example' => '15.3694'
            ],
            'longitude' => [
                'description' => 'The longitude for map location',
                'example' => '44.1910'
            ],
            'brand_id' => [
                'description' => 'The brand ID',
                'example' => 1
            ],
            'province_id' => [
                'description' => 'The province ID',
                'example' => 2
            ],
            'main_image' => [
                'description' => 'The main car image',
            ],
            'sub_image' => [
                'description' => 'The secondary image for the car',
            ],
        ];
    }
}