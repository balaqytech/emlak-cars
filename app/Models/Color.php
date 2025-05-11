<?php

namespace App\Models;

use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{
    use HasTranslations;

    protected $fillable = [
        'vehicle_model_id',
        'name',
        'hex',
        'image',
        'show_price',
        'cash_price',
        'installment_price',
        'is_available',
    ];

    protected $casts = [
        'show_price' => 'boolean',
    ];

    public $translatable = [
        'name',
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }
}
