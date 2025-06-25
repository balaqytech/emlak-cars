<?php

namespace App\Models;

use App\Enums\PurchaseApplicationStatus;
use App\Enums\PurchaseMethod;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class PurchaseApplication extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

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

    public function formatAuditFieldsForPresentation($field, \OwenIt\Auditing\Contracts\Audit $record)
    {
        $fields = \Illuminate\Support\Arr::wrap($record->{$field});

        $formattedResult = '<ul>';

        foreach ($fields as $key => $value) {
            $formattedResult .= '<li>';
            $formattedResult .= match ($key) {
                'status' => __('backend.purchase_applications.status') . ': ' . \App\Enums\PurchaseApplicationStatus::from($value)->getLabel(),
                'assigned_to' => __('backend.purchase_applications.assigned_to') . ': ' . \App\Models\User::find($value)?->name ?? __('backend.purchase_applications.unassigned'),
                default => ' - ',
            };
            $formattedResult .= '</li>';
        }

        $formattedResult .= '</ul>';

        return new \Illuminate\Support\HtmlString($formattedResult);
    }
}
