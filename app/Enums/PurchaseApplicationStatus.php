<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PurchaseApplicationStatus: string implements HasLabel
{
    case New = 'new';
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => __('backend.purchase_application_status.new'),
            self::Pending => __('backend.purchase_application_status.pending'),
            self::Approved => __('backend.purchase_application_status.approved'),
            self::Rejected => __('backend.purchase_application_status.rejected'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::New => 'info',
            self::Pending => 'warning',
            self::Approved => 'success',
            self::Rejected => 'primary',
        };
    }
}
