<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ContactPage extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.settings');
    }

    public function getTitle(): string
    {
        return __('backend.contact_page.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.contact_page.title');
    }

    public function getFileName(): string
    {
        return 'contact.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'opening_hours',
            'form_title',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Forms\Components\Tabs::make(__('backend.contact_page.contact_information'))
                ->tabs([
                    Forms\Components\Tabs\Tab::make(__('backend.contact_page.contact_information'))
                        ->schema([
                            Forms\Components\RichEditor::make('opening_hours')
                                ->required()
                                ->hint(__('backend.translatable_field'))
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.contact_page.opening_hours'))
                                ->toolbarButtons([
                                    'bold',
                                    'bulletList',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ]),
                            Forms\Components\TextInput::make('contact_email')
                                ->email()
                                ->required()
                                ->label(__('backend.contact_page.contact_email')),
                            Forms\Components\TextInput::make('contact_phone')
                                ->tel()
                                ->label(__('backend.contact_page.contact_phone')),
                            Forms\Components\FileUpload::make('image')
                                ->label(__('backend.contact_page.image'))
                                ->image()
                                ->required()
                        ]),

                    Forms\Components\Tabs\Tab::make(__('backend.contact_page.contact_form_settings'))
                        ->schema([
                            Forms\Components\TextInput::make('contact_form_title')
                                ->hint(__('backend.translatable_field'))
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.contact_page.contact_form_title')),
                            Forms\Components\TextInput::make('contact_form_email')
                                ->label(__('backend.contact_page.contact_form_email'))
                                ->helperText(__('backend.contact_page.contact_form_email_helper'))
                                ->email()
                                ->required(),
                        ]),
                ]),
        ];
    }
}
