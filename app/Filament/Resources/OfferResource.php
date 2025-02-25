<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Offer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\OfferResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OfferResource\RelationManagers;

class OfferResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $navigationGroup = 'Content Managment';

    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('backend.offers.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.offers.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('backend.offers.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backend.offers.slug'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label(__('backend.offers.image'))
                    ->image()
                    ->required(),
                Forms\Components\Textarea::make('excerpt')
                    ->label(__('backend.offers.excerpt'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('due_date')
                    ->label(__('backend.offers.due_date'))
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label(__('backend.offers.content'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('faqs')
                    ->label(__('backend.offers.faqs'))
                    ->schema([
                        Forms\Components\TextInput::make('question')
                            ->label(__('backend.offers.question'))
                            ->required(),
                        Forms\Components\Textarea::make('answer')
                            ->label(__('backend.offers.answer'))
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backend.offers.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backend.offers.slug'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.offers.image')),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('backend.offers.due_date'))
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
