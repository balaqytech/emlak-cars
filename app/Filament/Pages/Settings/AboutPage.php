<?php

namespace App\Filament\Pages\Settings;

use Filament\Forms;
use Panakour\FilamentFlatPage\Pages\FlatPage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class AboutPage extends FlatPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.settings');
    }

    public function getTitle(): string
    {
        return __('backend.about_page.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.about_page.title');
    }

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
                    Forms\Components\Tabs\Tab::make(__('backend.about_page.about'))
                        ->schema([
                            Forms\Components\TextInput::make('about_heading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.about_page.about_heading')),
                            Forms\Components\TextInput::make('about_subheading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.about_page.about_subheading')),
                            Forms\Components\RichEditor::make('about_description')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.about_page.about_description'))
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
                                ->label(__('backend.about_page.about_image'))
                                ->image()
                                ->required(),
                            Forms\Components\Repeater::make('facts')
                                ->label(__('backend.about_page.facts'))
                                ->schema([
                                    Forms\Components\TextInput::make('number')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.fact_number')),
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.fact_title')),
                                ])
                                ->defaultItems(3)
                                ->minItems(3)
                                ->maxItems(3)
                                ->deletable(false)
                                ->columns(2)
                        ]),

                    Forms\Components\Tabs\Tab::make(__('backend.about_page.vision_mission_values'))
                        ->schema([
                            Forms\Components\Section::make(__('backend.about_page.vision'))
                                ->schema([
                                    Forms\Components\TextInput::make('vision_title')
                                        ->maxLength(50)
                                        ->label(__('backend.about_page.vision_title')),
                                    Forms\Components\RichEditor::make('vision_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.vision_description'))
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
                            Forms\Components\Section::make(__('backend.about_page.mission'))
                                ->schema([
                                    Forms\Components\TextInput::make('mission_title')
                                        ->maxLength(50)
                                        ->label(__('backend.about_page.mission_title')),
                                    Forms\Components\RichEditor::make('mission_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.mission_description'))
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
                            Forms\Components\Section::make(__('backend.about_page.values'))
                                ->schema([
                                    Forms\Components\TextInput::make('values_title')
                                        ->maxLength(50)
                                        ->label(__('backend.about_page.values_title')),
                                    Forms\Components\RichEditor::make('values_description')
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.values_description'))
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

                    Forms\Components\Tabs\Tab::make(__('backend.about_page.partners'))
                        ->schema([
                            Forms\Components\FileUpload::make('partners')
                                ->label(__('backend.about_page.partners'))
                                ->image()
                                ->multiple()
                                ->maxSize(2 * 1024)
                                ->reorderable()
                                ->panelLayout('grid')
                        ]),

                    Forms\Components\Tabs\Tab::make(__('backend.about_page.history'))
                        ->schema([
                            Forms\Components\TextInput::make('history_heading')
                                ->required()
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.about_page.history_heading')),
                            Forms\Components\RichEditor::make('history_description')
                                ->hint('Translatable field.')
                                ->hintIcon('heroicon-o-language')
                                ->label(__('backend.about_page.history_description'))
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
                                ->label(__('backend.about_page.timeline'))
                                ->schema([
                                    Forms\Components\TextInput::make('year')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.timeline_year')),
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.timeline_title')),
                                    Forms\Components\RichEditor::make('description')
                                        ->required()
                                        ->hint('Translatable field.')
                                        ->hintIcon('heroicon-o-language')
                                        ->label(__('backend.about_page.timeline_description'))
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

                        Forms\Components\Tabs\Tab::make(__('backend.about_page.video'))
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->required()
                                    ->maxSize(1 * 1024)
                                    ->label(__('backend.about_page.video_image')),
                                Forms\Components\TextInput::make('video')
                                    ->required()
                                    ->url()
                                    ->label(__('backend.about_page.video_url'))
                                    ->hint(__('backend.about_page.video_url_hint')),
                            ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
