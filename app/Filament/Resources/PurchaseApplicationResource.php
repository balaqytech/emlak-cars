<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Color;
use Filament\Infolists;
use Filament\Tables\Table;
use App\Enums\PurchaseMethod;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseApplication;
use App\Enums\PurchaseApplicationStatus;
use Illuminate\Console\View\Components\Info;
use App\Filament\Resources\PurchaseApplicationResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

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
            ->modifyQueryUsing(
                fn($query) => $query->when(
                    !auth()->user()->hasRole('super_admin'),
                    fn($query) => $query->where('assigned_to', auth()->user()->id)
                )
                    ->latest()
                    ->with('assignedTo')
            )
            ->columns([
                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('backend.purchase_applications.payment_method'))
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fields.name')
                    ->label(__('backend.purchase_applications.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('fields.email')
                    ->label(__('backend.purchase_applications.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('fields.phone')
                    ->label(__('backend.purchase_applications.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('fields.city')
                    ->label(__('backend.purchase_applications.city'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('backend.purchase_applications.status'))
                    ->badge()
                    ->color(fn($state) => $state->getColor()),
                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('backend.purchase_applications.assigned_to'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backend.purchase_applications.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label(__('backend.purchase_applications.payment_method'))
                    ->options(PurchaseMethod::class),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('backend.purchase_applications.status'))
                    ->multiple()
                    ->options(PurchaseApplicationStatus::class),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label(__('backend.purchase_applications.assigned_to'))
                    ->relationship('assignedTo', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
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
                    ->schema(
                        fn($record) => collect([
                            Infolists\Components\TextEntry::make('payment_method')
                                ->label(__('backend.purchase_applications.payment_method'))
                                ->badge(),
                            Infolists\Components\TextEntry::make('status')
                                ->label(__('backend.purchase_applications.status'))
                                ->badge()
                                ->color(fn($state) => $state->getColor()),
                        ])
                            ->merge($record->fields->map(
                                fn($value, $key) => Infolists\Components\TextEntry::make($key)
                                    ->label(__('backend.purchase_applications.' . $key))
                                    ->state(fn() => $key == 'purchase_type' ? __('backend.purchase_types.' . $value) : $value)
                            ))
                            ->toArray()
                    ),
                Infolists\Components\Section::make(__('backend.purchase_applications.vehicle_details'))
                    ->columns(3)
                    ->schema(function ($record) {
                        $color = Color::find($record->vehicle_details['id']);
                        return [
                            InfoLists\Components\TextEntry::make('vehicle')
                                ->label(__('backend.vehicles.name'))
                                ->state(fn() => $color->model->vehicle->name),
                            InfoLists\Components\TextEntry::make('model')
                                ->label(__('backend.vehicles.model_name'))
                                ->state(fn() => $color->model->name),
                            InfoLists\Components\TextEntry::make('name')
                                ->label(__('backend.vehicles.color_name'))
                                ->state(fn() => $color->name),
                            InfoLists\Components\TextEntry::make('price')
                                ->label(fn() => $record->payment_method == PurchaseMethod::Cash ? __('backend.vehicles.cash_price') : __('backend.vehicles.installment_price'))
                                ->state(fn($record) => $record->payment_method == PurchaseMethod::Cash ? $color->cash_price : $color->installment_price),
                            InfoLists\Components\ImageEntry::make('image')
                                ->label(__('backend.vehicles.image'))
                                ->state(fn() => $color->image),
                        ];
                    }),
                Infolists\Components\Section::make(__('backend.purchase_applications.installment_details.section_title'))
                    ->columns(2)
                    ->hidden(fn($record) => $record->payment_method == PurchaseMethod::Cash)
                    ->schema(
                        fn($record) => collect($record->installment_details)
                            ->map(
                                fn($value, $key) => Infolists\Components\TextEntry::make($key)
                                    ->label(__('backend.purchase_applications.installment_details.' . $key))
                                    ->state($value)
                            )
                            ->toArray()
                    ),
                Infolists\Components\Section::make(__('backend.purchase_applications.attachements.section_title'))
                    ->columns(2)
                    ->hidden(fn($record) => $record->attachments == null)
                    ->schema(
                        fn($record) => collect($record->attachments)
                            ->map(
                                fn($value, $key) => Infolists\Components\TextEntry::make($key)
                                    ->label(__('backend.purchase_applications.attachements.' . $key))
                                    ->state(__('backend.purchase_applications.attachements.' . $key))
                                    ->url(asset('/storage/' . $value))
                                    ->openUrlInNewTab()
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
