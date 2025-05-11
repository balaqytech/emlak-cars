<?php

namespace App\Filament\Resources\VehicleModelResource\Pages;

use App\Filament\Resources\VehicleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVehicleModel extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = VehicleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
