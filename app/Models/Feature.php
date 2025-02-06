<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'feature_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(FeatureCategory::class, 'feature_category_id');
    }

    public function vehicleModels()
    {
        return $this->belongsToMany(VehicleModel::class)->withPivot('value');
    }
}
