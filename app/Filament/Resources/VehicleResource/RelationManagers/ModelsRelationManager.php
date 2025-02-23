<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class ModelsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'models';

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
                        ]),
                    Forms\Components\Wizard\Step::make('Model Colors')
                        ->schema([
                            Forms\Components\Repeater::make('colors')
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
                                        ->required(),
                                    Forms\Components\TextInput::make('installment_price')
                                        ->numeric()
                                        ->required(),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
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
