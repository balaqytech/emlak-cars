<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\VehicleCategory;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VehicleCategoryResource\Pages;
use App\Filament\Resources\VehicleCategoryResource\RelationManagers;

class VehicleCategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = VehicleCategory::class;

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('backend.vehicle_categories.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.vehicle_categories.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.vehicles');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('backend.vehicle_categories.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backend.vehicle_categories.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('backend.vehicle_categories.description'))
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('backend.vehicle_categories.is_active'))
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.vehicle_categories.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('backend.vehicle_categories.slug'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.vehicle_categories.is_active'))
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
            'index' => Pages\ManageVehicleCategories::route('/'),
        ];
    }
}
