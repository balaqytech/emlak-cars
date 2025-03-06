<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContactMethod: string implements HasLabel
{
    case SMS = 'sms';
    case Email = 'email';
    case Whatsapp = 'whatsapp';
    case Call = 'call';

    public function getLabel(): string
    {
        return match ($this) {
            self::SMS => __('frontend.contact_methods.sms'),
            self::Email => __('frontend.contact_methods.email'),
            self::Whatsapp => __('frontend.contact_methods.whatsapp'),
            self::Call => __('frontend.contact_methods.call'),
        };
    }
}
