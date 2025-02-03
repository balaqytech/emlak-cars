<?php

namespace App\Filament\Resources\FeatureCategoryResource\Pages;

use App\Filament\Resources\FeatureCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFeatureCategories extends ManageRecords
{
    protected static string $resource = FeatureCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
