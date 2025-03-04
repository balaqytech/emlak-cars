<?php

namespace App\Models;

use App\Casts\ModelColorCast;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'vehicle_id',
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

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }

    public function lowestPrice()
    {
        return $this->colors()->min('cash_price');
    }
}
