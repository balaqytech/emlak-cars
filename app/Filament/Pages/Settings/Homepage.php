<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Homepage extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.settings');
    }

    public function getTitle(): string
    {
        return __('backend.homepage.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.homepage.title');
    }

    public function getFileName(): string
    {
        return 'homepage.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'slider',
            'banner_title',
            'banner_subtitle',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make(__('backend.homepage.slider'))
                        ->schema([
                            Forms\Components\Repeater::make('slider')
                                ->label(__('backend.homepage.slider'))
                                ->hint(__('backend.translatable_field'))
                                ->hintIcon('heroicon-o-language')
                                ->schema([
                                    Forms\Components\FileUpload::make('laptop_image')
                                        ->required()
                                        ->image()
                                        ->maxSize(1 * 1024)
                                        ->label(__('backend.homepage.slider_laptop_image')),
                                    Forms\Components\FileUpload::make('mobile_image')
                                        ->required()
                                        ->image()
                                        ->maxSize(1 * 1024)
                                        ->label(__('backend.homepage.slider_mobile_image')),
                                    Forms\Components\TextInput::make('button_text')
                                        ->required()
                                        ->label(__('backend.homepage.slider_button_text')),
                                    Forms\Components\TextInput::make('button_link')
                                        ->required()
                                        ->url()
                                        ->label(__('backend.homepage.slider_button_link')),

                                ])
                                ->minItems(1)
                                ->columns(2)
                        ]),
                    Forms\Components\Tabs\Tab::make(__('backend.homepage.banner'))
                        ->schema([
                            Forms\Components\FileUpload::make('banner')
                                ->required()
                                ->image()
                                ->maxSize(1 * 1024)
                                ->label(__('backend.homepage.banner_image')),
                            Forms\Components\TextInput::make('banner_title')
                                ->required()
                                ->label(__('backend.homepage.banner_title')),
                            Forms\Components\TextInput::make('banner_subtitle')
                                ->required()
                                ->label(__('backend.homepage.banner_subtitle')),
                        ]),
                ]),
        ];
    }
}
