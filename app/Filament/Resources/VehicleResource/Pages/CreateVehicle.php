<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\VehicleResource;
use Illuminate\Validation\ValidationException;

class CreateVehicle extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = app(static::getModel());

        $translatableAttributes = static::getResource()::getTranslatableAttributes();

        $record->fill(Arr::except($data, $translatableAttributes));

        foreach (Arr::only($data, $translatableAttributes) as $key => $value) {
            $record->setTranslation($key, $this->activeLocale, $this->normalizeRepeaterTranslationValue($key, $value));
        }

        $originalData = $this->data;

        foreach ($this->otherLocaleData as $locale => $localeData) {
            $this->data = [
                ...$this->data,
                ...$localeData,
            ];

            try {
                $this->form->validate();
            } catch (ValidationException $exception) {
                continue;
            }

            $localeData = $this->mutateFormDataBeforeCreate($localeData);

            foreach (Arr::only($localeData, $translatableAttributes) as $key => $value) {
                $record->setTranslation($key, $locale, $this->normalizeRepeaterTranslationValue($key, $value));
            }
        }

        $this->data = $originalData;

        if (
            static::getResource()::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            return $this->associateRecordWithTenant($record, $tenant);
        }

        $record->save();

        return $record;
    }

    protected function normalizeRepeaterTranslationValue(string $key, mixed $value): mixed
    {
        // Normalize 'features' field only
        if ($key === 'features' && is_array($value)) {
            return array_map(function ($item) {
                if (is_array($item['image'] ?? null)) {
                    // Convert image from ['uuid' => 'filename.jpg'] to 'filename.jpg'
                    $item['image'] = array_values($item['image'])[0] ?? null;
                }

                return $item;
            }, $value);
        }

        return $value;
    }
}
