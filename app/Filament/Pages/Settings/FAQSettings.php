<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

class FAQSettings extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'FAQs Settings';

    public function getFileName(): string
    {
        return 'faqs.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'faqs',
            'groups',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Forms\Components\Tabs::make('FAQs Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('FAQs')
                        ->schema([
                            Forms\Components\Repeater::make('faqs')
                                ->schema([
                                    Forms\Components\TextInput::make('question')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('answer')
                                        ->required(),
                                    Forms\Components\Select::make('group')
                                        ->required()
                                        ->options(
                                            fn() => collect(FilamentFlatPage::get('faqs.json', 'groups'))->pluck('name', 'name')
                                        ),
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('FAQs Groups')
                        ->schema([
                            Forms\Components\Repeater::make('groups')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ])
                        ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
