<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;

class BranchResource extends Resource
{
    use Translatable;

    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('backend.branches.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.branches.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('backend.branches.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(__('backend.branches.address'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_mobile')
                    ->label(__('backend.branches.contact_mobile'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_whatsapp')
                    ->label(__('backend.branches.contact_whatsapp'))
                    ->helperText(__('backend.branches.contact_whatsapp_helper'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('map_embed')
                    ->label(__('backend.branches.map_embed'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('working_hours')
                    ->label(__('backend.branches.opening_hours'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('backend.branches.is_active'))
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.branches.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('backend.branches.address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_mobile')
                    ->label(__('backend.branches.contact_mobile'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_whatsapp')
                    ->label(__('backend.branches.contact_whatsapp'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.branches.is_active'))
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
            'index' => Pages\ManageBranches::route('/'),
        ];
    }
}
