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

    public function updateBrand($id, array $data)
{
    // جلب البراند من قاعدة البيانات
    $brand = $this->brand->findOrFail($id);

    // تحديث بيانات البراند
    $brand->update($data);

    return $brand; // إعادة البراند بعد التحديث
}

    

     public function all(){
        return $this->brand->all();

     }
    public function find($id){
        return $this->brand->findOrFail($id);
    }

       public function deleteBrand($id)
{
    $province =$this->brand->findOrFail($id);
    $province->delete();
    return true; // ترجع true إذا الحذف تم بنجاح
}

}