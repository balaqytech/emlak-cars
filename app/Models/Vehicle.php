<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'image',
        'banner',
        'overview',
        'colors',
        'features',
        'is_active',
        'vehicle_category_id',
        'vehicle_brand_id',
    ];

    protected $casts = [
        'colors' => 'array',
        'features' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }
}
