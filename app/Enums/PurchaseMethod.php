<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PurchaseMethod: string implements HasLabel
{
    case Cash = 'cash';
    case Installment = 'installment';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cash => __('backend.purchase_methods.cash'),
            self::Installment => __('backend.purchase_methods.installment'),
        };
    }
}
