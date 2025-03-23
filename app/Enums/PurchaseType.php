<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PurchaseType: string implements HasLabel {
    case Individual = 'individual';
    case Corporate = 'corporate';

    public function getLabel(): ?string
    {
        return match ($this){
            self::Individual => __('backend.purchase_types.individual'),
            self::Corporate => __('backend.purchase_types.corporate'),
        };
    }
}
