<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class GeneralSettings extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'General Settings';


    public function getSubheading(): ?string
    {
        return __('Manage your website settings');
    }

    public function getFileName(): string
    {
        return 'general_settings.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'site_name',
            'site_tagline',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Tabs::make('Settings')
                ->tabs([
                    Tabs\Tab::make('General')
                        ->icon('heroicon-o-computer-desktop')
                        ->columns(2)
                        ->schema([
                            TextInput::make('site_name')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Site Name'),
                            TextInput::make('site_tagline')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Site tagline'),
                            FileUpload::make('site_logo')
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label('Site Logo'),
                            FileUpload::make('site_favicon')
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label('Site Favicon'),
                            FileUpload::make('site_banner')
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label('Site Banner')
                                ->helperText('This will be displayed as page title background.')
                                ->columnSpanFull(),
                        ]),
                    Tabs\Tab::make('Social Networks')
                        ->icon('heroicon-o-heart')
                        ->schema([
                            Section::make('Social Media Links')
                                ->icon('heroicon-o-heart')
                                ->schema([
                                    TextInput::make('social.facebook')
                                        ->url()
                                        ->label('Facebook URL'),
                                    TextInput::make('social.twitter')
                                        ->url()
                                        ->label('Twitter URL'),
                                    TextInput::make('social.instagram')
                                        ->url()
                                        ->label('Instagram URL'),
                                    TextInput::make('social.linkedin')
                                        ->url()
                                        ->label('LinkedIn URL'),
                                ]),
                        ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
