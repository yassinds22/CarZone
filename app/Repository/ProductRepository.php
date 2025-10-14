<?php
namespace App\Repository;

use App\Models\Product;

class ProductRepository{ // تصحيح اسم الكلاس

    public $product;

    public function __construct(Product $product) {
        $this->product = $product; // تصحيح: يجب أن يكون $this->product بدون $
    }

    public function storeProduct(array $data) {
        return $this->product->create($data);
    }

    public function updateProduct($id, array $data) {
        $product = $this->product->findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function all() {
        return $this->product->all();
    }

    public function find($id) {
        return $this->product->findOrFail($id);
    }

    public function deleteProduct($id) {
        $product = $this->product->findOrFail($id); // تصحيح: تغيير $province إلى $product
        $product->delete();
        return true;
    }
}