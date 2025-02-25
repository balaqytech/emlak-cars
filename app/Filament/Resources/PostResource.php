<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Panel;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use DeepCopy\Filter\Filter;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Filament\Navigation\NavigationGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Traits\DisablesGlobalScopes;

class PostResource extends Resource
{
    use Translatable, DisablesGlobalScopes;

    protected static ?string $navigationGroup = 'Content Managment';

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-plus';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('backend.posts.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.posts.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.content_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Section::make(__('backend.posts.create_post'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('backend.posts.title'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->rule('min:3,max:255')
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('backend.posts.slug'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt')
                            ->label(__('backend.posts.excerpt'))
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->label(__('backend.posts.content'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('video')
                            ->label(__('backend.posts.video_url'))
                            ->helperText('Enter a valid video URL')
                            ->url()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make(__('backend.posts.additional_info'))
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label(__('backend.posts.image'))
                            ->image()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('backend.posts.publish'))
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label(__('backend.posts.is_featured'))
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('backend.posts.published_at'))
                            ->default(now()),
                        Forms\Components\Select::make('post_category_id')
                            ->label(__('backend.posts.category'))
                            ->relationship(name: 'category', titleAttribute: 'name')
                            ->required(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('backend.posts.image')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('backend.posts.title'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('backend.posts.is_published')),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('backend.posts.is_featured'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('backend.posts.published_at'))
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('backend.posts.category'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('Published Posts')
                    ->label(__('backend.posts.is_published'))
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
