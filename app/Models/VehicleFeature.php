<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleFeature extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'vehicle_id',
        'title',
        'description',
        'image',
        'order',
    ];

    // protected $casts = [
    //     'image' => 'json',
    // ];

    public $translatable = [
        'title',
        'description',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
