<?php

namespace App\Filament\Resources\VehicleModelResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class ColorsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'colors';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.colors.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('backend.colors.name'))
                    ->required(),
                Forms\Components\ColorPicker::make('hex')
                    ->label(__('backend.colors.hex'))
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label(__('backend.colors.image'))
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cash_price')
                    ->label(__('backend.colors.cash_price'))
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('installment_price', $state)),
                Forms\Components\TextInput::make('installment_price')
                    ->label(__('backend.colors.installment_price'))
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('show_price')
                    ->label(__('backend.colors.show_price'))
                    ->default(true),
                Forms\Components\Toggle::make('is_available')
                    ->label(__('backend.colors.is_available'))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.colors.name')),
                Tables\Columns\ColorColumn::make('hex')
                    ->label(__('backend.colors.hex')),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.colors.image')),
                Tables\Columns\IconColumn::make('show_price')
                    ->label(__('backend.colors.show_price'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_available')
                    ->label(__('backend.colors.is_available'))
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\LocaleSwitcher::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
