<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VehicleResource;
use Illuminate\Validation\ValidationException;

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
        return [];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $translatableAttributes = static::getResource()::getTranslatableAttributes();

        $record->fill(Arr::except($data, $translatableAttributes));

        // Normalize and set active locale translations
        foreach (Arr::only($data, $translatableAttributes) as $key => $value) {
            $record->setTranslation($key, $this->activeLocale, $this->normalizeRepeaterData($value));
        }

        $originalData = $this->data;

        $existingLocales = null;

        foreach ($this->otherLocaleData as $locale => $localeData) {
            $existingLocales ??= collect($translatableAttributes)
                ->map(fn(string $attribute): array => array_keys($record->getTranslations($attribute)))
                ->flatten()
                ->unique()
                ->all();

            $this->data = [
                ...$this->data,
                ...$localeData,
            ];

            // try {
            //     $this->form->validate();
            // } catch (ValidationException $exception) {
            //     if (! array_key_exists($locale, $existingLocales)) {
            //         continue;
            //     }

            //     $this->setActiveLocale($locale);

            //     throw $exception;
            // }

            $localeData = $this->mutateFormDataBeforeSave($localeData);

            foreach (Arr::only($localeData, $translatableAttributes) as $key => $value) {
                $record->setTranslation($key, $locale, $this->normalizeRepeaterData($value));
            }
        }

        $this->data = $originalData;

        $record->save();

        return $record;
    }

    protected function normalizeRepeaterData(mixed $value): mixed
    {
        // If it's an array and not already numerically indexed, normalize it
        if (is_array($value) && ! array_is_list($value)) {
            return array_values($value);
        }

        return $value;
    }
}
