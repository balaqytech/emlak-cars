<?php

namespace App\Filament\Resources\VehicleModelResource\Pages;

use App\Filament\Resources\VehicleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVehicleModel extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = VehicleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
