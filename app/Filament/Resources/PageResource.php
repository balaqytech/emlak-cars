<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Page;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\PageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PageResource\RelationManagers;

class PageResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('backend.pages.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.pages.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Section::make(__('backend.pages.create_page'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('backend.pages.title'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('backend.pages.slug'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt')
                            ->label(__('backend.pages.excerpt'))
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->label(__('backend.pages.content'))
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make(__('backend.pages.additional_info'))
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label(__('backend.pages.image'))
                            ->image()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('backend.pages.publish'))
                            ->required(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backend.pages.title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('excerpt')
                    ->label(__('backend.pages.excerpt'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.pages.image')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.pages.is_published'))
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
