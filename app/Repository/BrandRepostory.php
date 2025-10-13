<?php  
namespace App\Repository;

use App\Models\Brand;
use App\Models\Province;

class BrandRepostory{

       public $brand;
    public function __construct(Brand $brand){
        $this->brand=$brand;
    }
    public function storeProvince(array $data){
        return $this->brand->create($data);
    }
    

     public function all(){

     }
    public function find($id){
    }

}