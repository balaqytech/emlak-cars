<?php

namespace App\Models;

use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{
    protected $fillable = [
        'vehicle_model_id',
        'name',
        'hex',
        'image',
        'cash_price',
        'installment_price',
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }
}
