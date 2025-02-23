<?php

namespace App\Models;

use App\Casts\ModelColorCast;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class VehicleModel extends Model
{
    use HasTranslations;

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

    public $translatable = [
        'name',
        'excerpt',
        'overview',
        'specifications',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
