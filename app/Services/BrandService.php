<?php 
namespace App\Services;

use App\Models\Brand;
use App\Repository\BrandRepostory;


class BrandService{
    public $brandRepostory;
    public function __construct(BrandRepostory $brandRepostory){
        $this->brandRepostory=$brandRepostory;

    }
    public function saveBrand(array $data,$logo){
          $brand=$this->brandRepostory->storeProvince( $data);
          $this->uploadImage($brand,$logo);
          return $brand;
    }

            protected function uploadImage(Brand $client, $logo)
{
    if ($client->hasMedia('logo')) {
        $client->clearMediaCollection('logo');
    }
    $client->addMedia($logo)->toMediaCollection('logo');
}
}