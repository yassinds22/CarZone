<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
        use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    /**
     * العلاقة مع المحافظة الأم
     */
    public function parent()
    {
        return $this->belongsTo(Province::class, 'parent_id');
    }

    /**
     * العلاقة مع المحافظات الفرعية
     */
    public function children()
    {
        return $this->hasMany(Province::class, 'parent_id');
    }

      public function products()
    {
        return $this->hasMany(Product::class);
    }
    //
}
