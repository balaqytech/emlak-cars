<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Filament\Navigation\NavigationGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use DeepCopy\Filter\Filter;
use Filament\Panel;

class PostResource extends Resource
{
    //     Adding a badge to a navigation item and return the content of the badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static ?string $navigationGroup = 'Content Managment';

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Section::make('Creat a Post')
                    ->description('Create a new post over here.')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->rule('min:3,max:255')
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('video')
                            ->label('Video URL')
                            ->helperText('Enter a valid video URL')
                            ->url()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Additional Information')
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Publish')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at'),
                        Forms\Components\Select::make('post_category_id')
                            ->relationship(name: 'category', titleAttribute: 'name')
                            ->required(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Published'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('Published Posts')
                    ->query(
                        function (Builder $query): Builder {
                            return  $query->where('is_active', true);
                        }
                    )
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
