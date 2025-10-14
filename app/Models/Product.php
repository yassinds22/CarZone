<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
     use InteractsWithMedia;

    protected $fillable = [
        'title', 'description', 'model', 'price',
        'condition', 'engine_cylinders', 'fuel_type',
        'latitude', 'longitude', 'brand_id', 'province_id', 'user_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function user()
{   
    return $this->belongsTo(User::class);
}
    //
}
