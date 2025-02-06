<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
