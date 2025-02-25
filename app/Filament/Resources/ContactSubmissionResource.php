<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    public static function getModelLabel(): string
    {
        return __('backend.contact_submissions.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.contact_submissions.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.submissions');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.contact_submissions.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('backend.contact_submissions.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('backend.contact_submissions.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backend.contact_submissions.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->filters([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('backend.contact_submissions.details'))
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('backend.contact_submissions.name')),
                        Infolists\Components\TextEntry::make('phone')
                            ->label(__('backend.contact_submissions.phone')),
                        Infolists\Components\TextEntry::make('email')
                            ->label(__('backend.contact_submissions.email')),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label(__('backend.contact_submissions.created_at'))
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('message')
                            ->label(__('backend.contact_submissions.message')),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
        ];
    }
}
