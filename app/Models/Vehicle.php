<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class Vehicle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'image',
        'show_least_price',
        'banner',
        'overview',
        // 'features',
        'is_active',
        'vehicle_category_id',
        'vehicle_brand_id',
        'order',
        'is_featured',
    ];

    protected $casts = [
        // 'features' => 'array',
        'is_active' => 'boolean',
        'show_least_price' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public $translatable = [
        'name',
        'excerpt',
        'overview',
        // 'features',
    ];

    public function vehicleFeatures()
    {
        return $this->hasMany(VehicleFeature::class, 'vehicle_id');
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function vehicleModels()
    {
        return $this->hasMany(VehicleModel::class, 'vehicle_id');
    }

    public function getLeastPriceAttribute()
    {
        return $this->vehicleModels()
            ->join('colors', 'vehicle_models.id', '=', 'colors.vehicle_model_id')
            ->min('colors.cash_price');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
