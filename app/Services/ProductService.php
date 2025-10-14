<?php
namespace App\Services;

use App\Models\Product;
use App\Repository\ProductRepository;

class ProductService {
    public $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function getAll() {
        return $this->productRepository->all();
    }

    public function saveProduct(array $data, $image1 = null, $image2 = null) {
        $product = $this->productRepository->storeProduct($data);
        $this->uploadImage($product, $image1, $image2);
        return $product;
    }

    public function updateProduct($id, array $data, $image1 = null, $image2 = null) {
        $product = $this->productRepository->updateProduct($id, $data); // تصحيح: تغيير $brand إلى $product
        $this->uploadImage($product, $image1, $image2);
        return $product->fresh();
    }

    public function getById($id) {
        return $this->productRepository->find($id);
    }

    public function deleteProductById($id) {
        return $this->productRepository->deleteProduct($id);
    }

    protected function uploadImage(Product $product, $main_image = null, $sub_image = null) {
        if ($main_image) {
            if ($product->hasMedia('main_image')) {
                $product->clearMediaCollection('main_image');
            }
            $product->addMedia($main_image)->toMediaCollection('main_image');
        }

        if ($sub_image) {
            if ($product->hasMedia('sub_image')) {
                $product->clearMediaCollection('sub_image');
            }
            $product->addMedia($sub_image)->toMediaCollection('sub_image');
        }
    }
}