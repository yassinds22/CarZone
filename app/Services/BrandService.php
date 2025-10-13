<?php 
namespace App\Services;

use App\Models\Brand;
use App\Repository\BrandRepostory;


class BrandService{
    public $brandRepostory;
    public function __construct(BrandRepostory $brandRepostory){
        $this->brandRepostory=$brandRepostory;

    }
     public function getAll(){
        return $this->brandRepostory->all();
    }
    public function saveBrand(array $data,$log){
          $brand=$this->brandRepostory->storeProvince( $data);
          $this->uploadImage($brand,$log);
          return $brand;
    }

 public function updateBrand($id, array $data, $image = null)
{
    $brand = $this->brandRepostory->updateBrand($id, $data);

    if ($image) {
        $brand->addMedia($image)->toMediaCollection('brands');
    }

    return $brand->fresh(); // تأكد من إعادة الكائن محدثًا مع أي media
}

     public function getById($id){
        return $this->brandRepostory->find($id);
    }

    public function deleteBrandById($id)
{
    return $this->brandRepostory->deleteBrand($id);
}




     protected function uploadImage(Brand $client, $logo=null)
               {
    if ($client->hasMedia('logo')) {
        $client->clearMediaCollection('logo');
    }
    $client->addMedia($logo)->toMediaCollection('logo');
}
}