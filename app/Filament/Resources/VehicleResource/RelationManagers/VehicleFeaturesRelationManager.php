<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class VehicleFeaturesRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'vehicleFeatures';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.vehicles.features');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('backend.vehicles.feature_title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('backend.vehicles.feature_description'))
                    ->required()
                    ->maxLength(500),
                Forms\Components\FileUpload::make('image')
                    ->label(__('backend.vehicles.feature_image'))
                    ->image()
                    ->required()
                    ->maxSize(1024)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backend.vehicles.feature_title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('backend.vehicles.feature_description'))
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.vehicles.feature_image'))
                    ->circular(),
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
}
