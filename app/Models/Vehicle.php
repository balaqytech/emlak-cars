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
        'features',
        'is_active',
        'vehicle_category_id',
        'vehicle_brand_id',
    ];

    protected $casts = [
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

    public function models()
    {
        return $this->hasMany(VehicleModel::class, 'vehicle_id');
    }
}
