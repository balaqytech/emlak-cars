<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = [
        'name',
        'excerpt',
        'image',
        'overview',
        'price',
        'vehicle_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class)->withPivot('value');
    }
}
