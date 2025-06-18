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
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.settings');
    }

    public function getTitle(): string
    {
        return __('backend.faqs_page.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.faqs_page.title');
    }

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
            Forms\Components\Tabs::make(__('backend.faqs_page.faqs'))
                ->tabs([
                    Forms\Components\Tabs\Tab::make(__('backend.faqs_page.faqs'))
                        ->schema([
                            Forms\Components\Repeater::make('faqs')
                                ->label(__('backend.faqs_page.faqs'))
                                ->schema([
                                    Forms\Components\TextInput::make('question')
                                        ->label(__('backend.faqs_page.question'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('answer')
                                        ->label(__('backend.faqs_page.answer'))
                                        ->required(),
                                    Forms\Components\Select::make('group')
                                        ->label(__('backend.faqs_page.group'))
                                        ->required()
                                        ->options(
                                            fn() => collect(FilamentFlatPage::get('faqs.json', 'groups', $this->activeLocale))->pluck('name', 'name')
                                        ),
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make(__('backend.faqs_page.groups'))
                        ->schema([
                            Forms\Components\Repeater::make('groups')
                                ->label(__('backend.faqs_page.groups'))
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label(__('backend.faqs_page.group_name'))
                                        ->required()
                                        ->maxLength(255),
                                ])
                        ]),
                ])
                ->columnSpan('full'),
        ];
    }
}
