<?php

namespace App\Models;

use App\Enums\PurchaseMethod;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class PurchaseApplication extends Model
{
    protected $fillable = [
        'payment_method',
        'name',
        'email',
        'phone',
        'city',
        'contact_via',
        'vehicle_details',
        'installment_details',
    ];

    protected $casts = [
        'payment_method' => PurchaseMethod::class,
        'contact_via' => 'array',
        'vehicle_details' => 'array',
        'installment_details' => SchemalessAttributes::class,
    ];

    public function scopeWithVehicleDetails($query)
    {
        return $query->vehicle_details->modelScope();
    }

    public function scopeWithInstallmentDetails($query)
    {
        return $query->installment_details->modelScope();
    }
}
