<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Page;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PageResource\RelationManagers;

class PageResource extends Resource
{
    protected static ?string $navigationGroup = 'Content Managment';

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(3)
        ->schema([
            Forms\Components\Section::make('Page Information')
                ->columnSpan(2)
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('excerpt')
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Additional Information')
                ->columnSpan(1)
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->required(),
                    Forms\Components\Toggle::make('is_active')
                        ->required(),
                    Forms\Components\Toggle::make('is_published')
                        ->required(),
                    Forms\Components\DateTimePicker::make('published_at'),
                    Forms\Components\Select::make('user_id')
                        ->label('Author')
                        ->relationship(name: 'user', titleAttribute: 'name')->required(),
                ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('excerpt')
                ->searchable(),
            Tables\Columns\ImageColumn::make('image'),
            Tables\Columns\IconColumn::make('is_active')
                ->sortable()
                ->boolean(),
            Tables\Columns\IconColumn::make('is_published')
                ->sortable()
                ->boolean(),
            Tables\Columns\TextColumn::make('published_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('user.name')
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
