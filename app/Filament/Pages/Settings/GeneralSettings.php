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
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.settings');
    }

    public function getTitle(): string
    {
        return __('backend.general_settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.general_settings.title');
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
                        ->label(__('backend.general_settings.general'))
                        ->icon('heroicon-o-computer-desktop')
                        ->columns(2)
                        ->schema([
                            TextInput::make('site_name')
                                ->label(__('backend.general_settings.site_name'))
                                ->required()
                                ->hint(__('backend.translatable_field'))
                                ->hintIcon('heroicon-o-language'),
                            TextInput::make('site_tagline')
                                ->label(__('backend.general_settings.site_tagline'))
                                ->required()
                                ->hint(__('backend.translatable_field'))
                                ->hintIcon('heroicon-o-language'),
                            FileUpload::make('site_logo')
                                ->required()
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label(__('backend.general_settings.site_logo')),
                            FileUpload::make('site_favicon')
                                ->required()
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label(__('backend.general_settings.site_favicon')),
                            FileUpload::make('site_banner')
                                ->required()
                                ->image()
                                ->maxSize(2 * 1024)
                                ->label(__('backend.general_settings.site_banner'))
                                ->helperText(__('backend.general_settings.site_banner_helper'))
                                ->columnSpanFull(),
                        ]),
                    Tabs\Tab::make('Social Networks')
                        ->label(__('backend.general_settings.social_networks'))
                        ->schema([
                            Section::make(__('backend.general_settings.social_networks'))
                                ->icon('heroicon-o-heart')
                                ->schema([
                                    TextInput::make('social.facebook')
                                        ->label(__('backend.social.facebook'))
                                        ->url(),
                                    TextInput::make('social.twitter')
                                        ->url()
                                        ->label(__('backend.social.twitter')),
                                    TextInput::make('social.instagram')
                                        ->url()
                                        ->label(__('backend.social.instagram')),
                                    TextInput::make('social.linkedin')
                                        ->url()
                                        ->label(__('backend.social.linkedin')),
                                    TextInput::make('social.youtube')
                                        ->url()
                                        ->label(__('backend.social.youtube')),
                                    TextInput::make('social.whatsapp')
                                        ->url()
                                        ->label(__('backend.social.whatsapp')),
                                ]),
                        ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
