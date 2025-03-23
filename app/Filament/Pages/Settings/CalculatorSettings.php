<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CalculatorSettings extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.installment_calculator');
    }

    public function getTitle(): string
    {
        return __('backend.calculator_settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.calculator_settings.title');
    }

    public function getFileName(): string
    {
        return 'calculator.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'license_types',
            'job_types',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Forms\Components\Tabs::make(__('backend.calculator_settings.license_and_job_types'))
            ->tabs([
                    Forms\Components\Tabs\Tab::make(__('backend.calculator_settings.general_settings'))
                        ->schema([
                            Forms\Components\Toggle::make('activate')
                                ->label(__('backend.calculator_settings.activate'))
                                ->required(),
                        ]), 
                    Forms\Components\Tabs\Tab::make(__('backend.calculator_settings.license_types'))
                        ->schema([
                            Forms\Components\Repeater::make('license_types')
                                ->label(__('backend.calculator_settings.license_types'))
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label(__('backend.calculator_settings.license_type_name'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('amount')
                                        ->label(__('backend.calculator_settings.license_type_amount'))
                                        ->required()
                                        ->numeric(),
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make(__('backend.calculator_settings.job_types'))
                        ->schema([
                            Forms\Components\Repeater::make('job_types')
                                ->label(__('backend.calculator_settings.job_types'))
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label(__('backend.calculator_settings.job_type_name'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('percentage')
                                        ->label(__('backend.calculator_settings.job_type_percentage'))
                                        ->required()
                                        ->numeric(),
                                ])
                        ]),
                ])
        ];
    }
}
