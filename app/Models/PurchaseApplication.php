<?php

namespace App\Models;

use App\Enums\PurchaseApplicationStatus;
use App\Enums\PurchaseMethod;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class PurchaseApplication extends Model
{
    protected $fillable = [
        'payment_method',
        'fields',
        'attachments',
        'vehicle_details',
        'installment_details',
        'status',
        'assigned_to',
    ];

    protected $casts = [
        'payment_method' => PurchaseMethod::class,
        'fields' => SchemalessAttributes::class,
        'attachments' => 'array',
        'vehicle_details' => SchemalessAttributes::class,
        'installment_details' => SchemalessAttributes::class,
        'status' => PurchaseApplicationStatus::class,
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeWithFields($query)
    {
        return $query->fields->modelScope();
    }

    public function scopeWithVehicleDetails($query)
    {
        return $query->vehicle_details->modelScope();
    }

    public function scopeWithInstallmentDetails($query)
    {
        return $query->installment_details->modelScope();
    }
}
