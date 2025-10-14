<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @group Products Management
 *
 * APIs for managing products.
 *
 * @bodyParam title string required اسم المنتج. Example: Toyota Corolla
 * @bodyParam description string وصف المنتج أو تفاصيل إضافية. Example: سيارة بحالة ممتازة، موديل 2022.
 * @bodyParam model string رقم أو اسم الموديل. Example: Corolla 2022
 * @bodyParam price numeric required سعر المنتج بالعملة المحلية. Example: 15000
 * @bodyParam condition string required حالة السيارة. Must be one of: جديدة, مستخدمة, مصدومة. Example: جديدة
 * @bodyParam engine_cylinders string required عدد سلندرات المحرك. Must be one of: 4, 6, 8. Example: 6
 * @bodyParam fuel_type string required نوع الوقود المستخدم. Must be one of: ديزل, بترول, كهرباء, هجين. Example: هجين
 * @bodyParam brand_id integer ID الماركة، يجب أن تكون موجودة في جدول brands. Example: 3
 * @bodyParam province_id integer ID المحافظة، يجب أن تكون موجودة في جدول provinces. Example: 2
 * @bodyParam user_id integer required ID المستخدم الذي أنشأ المنتج (يتم جلبه عادة من Auth). Example: 1
 * @bodyParam latitude numeric الإحداثي العرضي للموقع (Google Maps). Example: 15.3694
 * @bodyParam longitude numeric الإحداثي الطولي للموقع (Google Maps). Example: 44.1910
 * @bodyParam image1 file أول صورة للمنتج (غالبًا الصورة الرئيسية). Example: car_front.jpg
 * @bodyParam image2 file صورة إضافية للمنتج (غالبًا من زاوية أخرى). Example: car_back.jpg
 */
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // يمكنك تغييرها إلى auth()->check() لو أردت التحقق من تسجيل الدخول
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'model' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:جديدة,مستخدمة,مصدومة',
            'engine_cylinders' => 'required|in:4,6,8',
            'fuel_type' => 'required|in:ديزل,بترول,كهرباء,هجين',
            'brand_id' => 'nullable|exists:brands,id',
            'province_id' => 'nullable|exists:provinces,id',
            'user_id' => 'required|exists:users,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The product title is required.',
            'price.numeric' => 'The price must be a valid number.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'province_id.exists' => 'The selected province does not exist.',
            'user_id.exists' => 'The selected user does not exist.',
            'condition.in' => 'Invalid car condition selected.',
            'fuel_type.in' => 'Invalid fuel type selected.',
        ];
    }
}
