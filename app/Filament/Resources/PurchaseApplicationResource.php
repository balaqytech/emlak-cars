<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseApplicationResource\Pages;
use App\Models\PurchaseApplication;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Infolists;
use Filament\Tables\Table;
use Illuminate\Console\View\Components\Info;

class PurchaseApplicationResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PurchaseApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getModelLabel(): string
    {
        return __('backend.purchase_applications.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backend.purchase_applications.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.navigation_groups.submissions');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('backend.purchase_applications.payment_method'))
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('backend.purchase_applications.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('backend.purchase_applications.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('backend.purchase_applications.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label(__('backend.purchase_applications.city'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backend.purchase_applications.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('backend.purchase_applications.contact_details'))
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label(__('backend.purchase_applications.payment_method'))
                            ->badge(),
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('backend.purchase_applications.name')),
                        Infolists\Components\TextEntry::make('email')
                            ->label(__('backend.purchase_applications.email')),
                        Infolists\Components\TextEntry::make('phone')
                            ->label(__('backend.purchase_applications.phone')),
                        Infolists\Components\TextEntry::make('city')
                            ->label(__('backend.purchase_applications.city')),
                        InfoLists\Components\TextEntry::make('contact_via')
                            ->label(__('backend.purchase_applications.contact_via')),
                    ]),
                Infolists\Components\Section::make(__('backend.purchase_applications.vehicle_details'))
                    ->columns(2)
                    ->schema(
                        fn($record) => collect($record->vehicle_details)
                            ->map(
                                fn($value, $key) => Infolists\Components\TextEntry::make($key)
                                    ->label(ucwords(str_replace('_', ' ', $key)))
                                    ->state($value)
                            )
                            ->toArray()
                    ),
                Infolists\Components\Section::make(__('backend.purchase_applications.installment_details'))
                    ->columns(2)
                    ->schema(
                        fn($record) => collect($record->installment_details)
                            ->map(
                                fn($value, $key) => Infolists\Components\TextEntry::make($key)
                                    ->label(ucwords(str_replace('_', ' ', $key)))
                                    ->state($value)
                            )
                            ->toArray()
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseApplications::route('/'),
            'view' => Pages\ViewPurchaseApplication::route('/{record}'),
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
