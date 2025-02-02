<?php

namespace App\Filament\Resources\VehicleCategoryResource\Pages;

use App\Filament\Resources\VehicleCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVehicleCategories extends ManageRecords
{
    protected static string $resource = VehicleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
