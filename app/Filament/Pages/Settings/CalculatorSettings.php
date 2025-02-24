<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CalculatorSettings extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Calculator Settings';

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
            Forms\Components\Tabs::make('Calculator Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('License Type')
                        ->schema([
                            Forms\Components\Repeater::make('license_types')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('amount')
                                        ->required()
                                        ->numeric(),
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('Job Type')
                        ->schema([
                            Forms\Components\Repeater::make('job_types')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('percentage')
                                        ->required()
                                        ->numeric(),
                                ])
                        ]),
                ])
        ];
    }
}
