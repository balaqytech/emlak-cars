<?php

namespace App\Filament\Resources\VehicleModelResource\Pages;

use App\Filament\Resources\VehicleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleModel extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = VehicleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
