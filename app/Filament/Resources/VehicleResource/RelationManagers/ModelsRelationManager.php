<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class ModelsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'vehicleModels';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Model Details')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('slug')
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
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->required(),
                            Forms\Components\RichEditor::make('overview')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('specifications')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Toggle::make('is_active')
                                ->default(true),
                        ]),
                    Forms\Components\Wizard\Step::make('Model Colors')
                        ->schema([
                            Forms\Components\Repeater::make('colors')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required(),
                                    Forms\Components\ColorPicker::make('hex')
                                        ->required(),
                                    Forms\Components\FileUpload::make('image')
                                        ->image()
                                        ->required(),
                                    Forms\Components\TextInput::make('cash_price')
                                        ->numeric()
                                        ->default(0)
                                        ->required(),
                                    Forms\Components\TextInput::make('installment_price')
                                        ->numeric()
                                        ->default(0)
                                        ->required(),
                                    Forms\Components\Toggle::make('show_price')
                                        ->default(true),
                                    Forms\Components\Toggle::make('is_available')
                                        ->default(true),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes())
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
