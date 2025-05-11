<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VehicleModelResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class ModelsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'vehicleModels';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.vehicle_models.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('backend.vehicle_models.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('backend.vehicle_models.slug'))
                            ->required()
                            ->unique(
                                table: 'vehicle_models',
                                column: 'slug',
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule) =>
                                $rule->where('vehicle_id', $this->getOwnerRecord()->id)
                            )
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt')
                            ->label(__('backend.vehicle_models.excerpt'))
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label(__('backend.vehicle_models.image'))
                            ->image()
                            ->required()
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

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes())
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.vehicle_models.name')),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.vehicle_models.image')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.vehicle_models.is_active'))
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->successRedirectUrl(fn(Model $record): string => VehicleModelResource::getUrl('view', ['record' => $record])),
                Tables\Actions\LocaleSwitcher::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn(Model $record): string => VehicleModelResource::getUrl('view', ['record' => $record])),
                Tables\Actions\EditAction::make()
                    ->url(fn(Model $record): string => VehicleModelResource::getUrl('edit', ['record' => $record])),
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
