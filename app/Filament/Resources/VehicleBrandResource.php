<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\VehicleBrand;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VehicleBrandResource\Pages;
use App\Filament\Resources\VehicleBrandResource\RelationManagers;

class VehicleBrandResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $model = VehicleBrand::class;

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('backend.vehicle_brands.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.vehicle_brands.label');
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
                    ->label(__('backend.vehicle_brands.name'))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label(__('backend.vehicle_brands.slug'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logo')
                    ->label(__('backend.vehicle_brands.logo'))
                    ->required()
                    ->image()
                    ->imageCropAspectRatio('1:1')
                    ->disk('public')
                    ->directory('vehicle-brands'),
                Forms\Components\Textarea::make('description')
                    ->label(__('backend.vehicle_brands.description')),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('backend.vehicle_brands.is_active'))
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label(__('backend.vehicle_brands.logo')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.vehicle_brands.name'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.vehicle_brands.is_active'))
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
            'index' => Pages\ManageVehicleBrands::route('/'),
        ];
    }
}
