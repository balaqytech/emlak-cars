<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Bank;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\BankResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BankResource\RelationManagers;

class BankResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $model = Bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function getModelLabel(): string
    {
        return __('backend.banks.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.banks.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.installment_calculator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('backend.banks.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('percentage')
                    ->label(__('backend.banks.percentage'))
                    ->required()
                    ->numeric()
                    ->rule('min:1'),
                Forms\Components\TextInput::make('benefits')
                    ->label(__('backend.banks.benefits'))
                    ->required()
                    ->numeric()
                    ->rule('min:1'),
                Forms\Components\TextInput::make('insurance')
                    ->label(__('backend.banks.insurance'))
                    ->required()
                    ->numeric()
                    ->rule('min:1'),
                Forms\Components\TextInput::make('management_fees')
                    ->label(__('backend.banks.management_fees'))
                    ->required()
                    ->numeric()
                    ->rule('min:1'),
                Forms\Components\TextInput::make('period')
                    ->label(__('backend.banks.period'))
                    ->helperText(__('backend.banks.period_helper'))
                    ->required()
                    ->numeric()
                    ->rule('min:1'),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('backend.banks.is_active'))
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.banks.name'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('percentage')
                    ->label(__('backend.banks.percentage'))
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('benefits')
                    ->label(__('backend.banks.benefits'))
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insurance')
                    ->label(__('backend.banks.insurance'))
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('management_fees')
                    ->label(__('backend.banks.management_fees'))
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->label(__('backend.banks.period'))
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.banks.is_active'))
                    ->sortable()
                    ->toggleable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBanks::route('/'),
        ];
    }
}
