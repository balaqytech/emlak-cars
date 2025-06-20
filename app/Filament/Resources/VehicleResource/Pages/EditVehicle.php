<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VehicleResource;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\VehicleResource\RelationManagers\VehicleFeaturesRelationManager;

class EditVehicle extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            VehicleFeaturesRelationManager::class,
        ];
    }
}
