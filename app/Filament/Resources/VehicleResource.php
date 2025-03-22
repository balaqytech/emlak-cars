<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vehicle;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\VehicleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Filament\Resources\VehicleResource\RelationManagers\ModelsRelationManager;

class VehicleResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $model = Vehicle::class;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('backend.vehicles.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.vehicles.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.vehicles');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Car Details')
                        ->label(__('backend.vehicles.car_details'))
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('backend.vehicles.name'))
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            Forms\Components\TextInput::make('slug')
                                ->label(__('backend.vehicles.slug'))
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            Forms\Components\Textarea::make('excerpt')
                                ->label(__('backend.vehicles.excerpt'))
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make('image')
                                ->label(__('backend.vehicles.image'))
                                ->image()
                                ->required(),
                            Forms\Components\FileUpload::make('banner')
                                ->label(__('backend.vehicles.banner'))
                                ->image()
                                ->required(),
                            Forms\Components\RichEditor::make('overview')
                                ->label(__('backend.vehicles.overview'))
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('vehicle_category_id')
                                ->label(__('backend.vehicles.category'))
                                ->relationship('category', 'name')
                                ->required(),
                            Forms\Components\Select::make('vehicle_brand_id')
                                ->label(__('backend.vehicles.brand'))
                                ->relationship('brand', 'name')
                                ->required(),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->label(__('backend.vehicles.published_at'))
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->label(__('backend.vehicles.is_active'))
                                ->required()
                                ->default(true),
                            Forms\Components\Toggle::make('show_least_price')
                                ->label(__('backend.vehicles.show_least_price'))
                                ->required()
                                ->default(true),
                        ]),
                    Forms\Components\Wizard\Step::make('Car Features')
                        ->label(__('backend.vehicles.features'))
                        ->schema([
                            Forms\Components\Repeater::make('features')
                                ->label(__('backend.vehicles.features'))
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label(__('backend.vehicles.feature_title'))
                                        ->required(),
                                    Forms\Components\Textarea::make('description')
                                        ->label(__('backend.vehicles.feature_description'))
                                        ->required(),
                                    Forms\Components\FileUpload::make('image')
                                        ->label(__('backend.vehicles.feature_image'))
                                        ->image()
                                        ->required(),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('published_at', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.vehicles.name'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.vehicles.image')),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('backend.vehicles.category'))
                    ->sortable(),
                Tables\Columns\ImageColumn::make('brand.logo')
                    ->label(__('backend.vehicles.brand'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.vehicles.is_active'))
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
                Tables\Actions\ViewAction::make(),
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
            ModelsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view' => Pages\ViewVehicle::route('/{record}'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
