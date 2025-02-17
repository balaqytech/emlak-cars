<?php

namespace App\Models;

use App\Casts\ModelColorCast;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = [
        'name',
        'excerpt',
        'image',
        'overview',
        'specifications',
        'colors',
        'vehicle_id',
    ];

    protected $casts = [
        'colors' => ModelColorCast::class,
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
