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
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VehicleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VehicleResource\RelationManagers;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Vehicles';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Car Details')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('excerpt')
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->required(),
                            Forms\Components\FileUpload::make('banner')
                                ->image()
                                ->required(),
                            Forms\Components\RichEditor::make('overview')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('vehicle_category_id')
                                ->relationship('category', 'name')
                                ->required(),
                            Forms\Components\Select::make('vehicle_brand_id')
                                ->relationship('brand', 'name')
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->required(),
                        ]),
                    Forms\Components\Wizard\Step::make('Car Features')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Repeater::make('features')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->required(),
                                    Forms\Components\Textarea::make('description')
                                        ->required(),
                                    Forms\Components\FileUpload::make('image')
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
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('excerpt')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('banner')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('vehicle_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicle_brand_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
