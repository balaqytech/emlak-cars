<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\VehicleModel;
use Filament\Resources\Resource;
use App\Traits\DisablesGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VehicleModelResource\Pages;
use App\Filament\Resources\VehicleModelResource\RelationManagers;

class VehicleModelResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $model = VehicleModel::class;

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('backend.vehicle_models.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.vehicle_models.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.vehicles');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('backend.vehicle_models.model_details'))
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('vehicle_id')
                            ->label(__('backend.vehicle_models.vehicle'))
                            ->relationship('vehicle', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive(),
                        Forms\Components\TextInput::make('name')
                            ->label(__('backend.vehicle_models.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('backend.vehicle_models.slug'))
                            ->required()
                            ->unique(
                                table: 'vehicle_models',
                                column: 'slug',
                                ignoreRecord: true,
                                modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, callable $get) {
                                    return $rule->where('vehicle_id', $get('vehicle_id'));
                                }
                            )
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label(__('backend.vehicle_models.image'))
                            ->image()
                            ->required(),
                        Forms\Components\Textarea::make('excerpt')
                            ->label(__('backend.vehicle_models.excerpt'))
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('overview')
                            ->label(__('backend.vehicle_models.overview'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('specifications')
                            ->label(__('backend.vehicle_models.specifications'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('backend.vehicle_models.is_active'))
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.vehicle_models.image')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.vehicle_models.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.name')
                    ->label(__('backend.vehicle_models.vehicle'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('excerpt')
                    ->label(__('backend.vehicle_models.excerpt'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.vehicle_models.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backend.vehicle_models.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vehicle')
                    ->relationship('vehicle', 'name')
                    ->label(__('backend.vehicle_models.vehicle'))
                    ->multiple()
                    ->preload(),
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
            RelationManagers\ColorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleModels::route('/'),
            'create' => Pages\CreateVehicleModel::route('/create'),
            'view' => Pages\ViewVehicleModel::route('/{record}'),
            'edit' => Pages\EditVehicleModel::route('/{record}/edit'),
        ];
    }
}
