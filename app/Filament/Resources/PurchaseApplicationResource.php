<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseApplicationResource\Pages;
use App\Models\PurchaseApplication;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Infolists;
use Filament\Tables\Table;
use Illuminate\Console\View\Components\Info;

class PurchaseApplicationResource extends Resource
{
    protected static ?string $model = PurchaseApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
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
                Infolists\Components\Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Payment Method')
                            ->badge(),
                        Infolists\Components\TextEntry::make('name')
                            ->label('Name'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Phone'),
                        Infolists\Components\TextEntry::make('city')
                            ->label('City'),
                        InfoLists\Components\TextEntry::make('contact_via')
                            ->label('Contact Via'),
                    ]),
                Infolists\Components\Section::make('Vehicle Details')
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
                Infolists\Components\Section::make('Installment Details')
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
}
