<?php

namespace App\Models;

use App\Casts\ModelColorCast;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

class VehicleModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
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
