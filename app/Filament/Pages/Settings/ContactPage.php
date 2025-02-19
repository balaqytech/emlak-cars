<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;

class ContactPage extends FlatPage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Manage Contact Page';

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
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Contact Information')
                        ->schema([
                            Forms\Components\RichEditor::make('opening_hours')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Opening Hours')
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
                                ->label('Contact Email'),
                            Forms\Components\TextInput::make('contact_phone')
                                ->tel()
                                ->label('Contact Phone'),
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->required()
                        ]),

                    Forms\Components\Tabs\Tab::make('Contact Form Settings')
                        ->schema([
                            Forms\Components\TextInput::make('contact_form_title')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Contact Form Title'),
                            Forms\Components\TextInput::make('contact_form_email')
                                ->label('Contact Form Email')
                                ->helperText('This is the email that recieves the forms submissions')
                                ->email()
                                ->required(),
                        ]),
                ]),
        ];
    }
}
