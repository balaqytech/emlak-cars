<?php

namespace App\Filament\Resources\VehicleBrandResource\Pages;

use App\Filament\Resources\VehicleBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVehicleBrands extends ManageRecords
{
    use ManageRecords\Concerns\Translatable;

    protected static string $resource = VehicleBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
