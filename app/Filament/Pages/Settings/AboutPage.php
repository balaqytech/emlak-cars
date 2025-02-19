<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;

class AboutPage extends FlatPage
{
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Manage About Page';

    public function getFileName(): string
    {
        return 'about.json';
    }

    protected function getTranslatableFields(): array
    {
        return [
            'about_heading',
            'about_subheading',
            'about_description',
            'facts',
            'vision_title',
            'vision_description',
            'mission_title',
            'mission_description',
            'values_title',
            'values_description',
            'history_heading',
            'history_description',
            'timeline',
        ];
    }

    protected function getFlatFilePageForm(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('About Company')
                        ->schema([
                            Forms\Components\TextInput::make('about_heading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Heading'),
                            Forms\Components\TextInput::make('about_subheading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Sub Heading'),
                            Forms\Components\RichEditor::make('about_description')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Description')
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
                            Forms\Components\FileUpload::make('about_image')
                                ->image()
                                ->required(),
                            Forms\Components\Repeater::make('facts')
                                ->schema([
                                    Forms\Components\TextInput::make('number')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Number'),
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Title'),
                                ])
                                ->defaultItems(3)
                                ->minItems(3)
                                ->maxItems(3)
                                ->deletable(false)
                                ->columns(2)
                        ]),

                    Forms\Components\Tabs\Tab::make('Vision and Mission')
                        ->schema([
                            Forms\Components\Section::make('Vision')
                                ->schema([
                                    Forms\Components\TextInput::make('vision_title')
                                        ->maxLength(50)
                                        ->label('Title'),
                                    Forms\Components\RichEditor::make('vision_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Description')
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
                                ]),
                            Forms\Components\Section::make('Mission')
                                ->schema([
                                    Forms\Components\TextInput::make('mission_title')
                                        ->maxLength(50)
                                        ->label('Title'),
                                    Forms\Components\RichEditor::make('mission_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Description')
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
                                ]),
                            Forms\Components\Section::make('Values')
                                ->schema([
                                    Forms\Components\TextInput::make('values_title')
                                        ->maxLength(50)
                                        ->label('Title'),
                                    Forms\Components\RichEditor::make('values_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Description')
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
                                ]),
                        ]),

                    Forms\Components\Tabs\Tab::make('Partners')
                        ->schema([
                            Forms\Components\FileUpload::make('partners')
                                ->image()
                                ->multiple()
                                ->maxSize(2 * 1024)
                                ->reorderable()
                                ->panelLayout('grid')
                        ]),

                    Forms\Components\Tabs\Tab::make('Company History')
                        ->schema([
                            Forms\Components\TextInput::make('history_heading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Heading'),
                            Forms\Components\RichEditor::make('history_description')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label('Description')
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
                            Forms\Components\Repeater::make('timeline')
                                ->schema([
                                    Forms\Components\TextInput::make('year')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Year'),
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Title'),
                                    Forms\Components\RichEditor::make('description')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label('Description')
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
                                ])
                        ]),

                        Forms\Components\Tabs\Tab::make('Video')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->required()
                                    ->maxSize(1 * 1024)
                                    ->label('Image Placeholder'),
                                Forms\Components\TextInput::make('video')
                                    ->required()
                                    ->url()
                                    ->label('Video URL')
                                    ->hint('Enter the video URL from YouTube or Vimeo.'),
                            ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
