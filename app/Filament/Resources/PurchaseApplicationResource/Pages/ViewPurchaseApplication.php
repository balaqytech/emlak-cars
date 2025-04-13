<?php

namespace App\Filament\Resources\PurchaseApplicationResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Select;
use App\Enums\PurchaseApplicationStatus;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PurchaseApplicationResource;

class ViewPurchaseApplication extends ViewRecord
{
    protected static string $resource = PurchaseApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('assign')
                ->label(__('backend.purchase_applications.assign_to'))
                ->color('success')
                ->icon('heroicon-o-user-plus')
                ->modalWidth('lg')
                ->visible(fn () => auth()->user()->hasRole('super_admin'))
                ->form([
                    Select::make('assigned_to')
                        ->label(__('backend.purchase_applications.assign_to'))
                        ->relationship('assignedTo', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->placeholder(__('backend.purchase_applications.select_user')),
                ])
                ->action(function (array $data) {
                    $this->record->update(['assigned_to' => $data['assigned_to']]);
                    Notification::make()
                        ->title(__('backend.purchase_applications.assigned_successfully'))
                        ->success()
                        ->send();
                }),
            Actions\Action::make('changeStatus')
                ->label(__('backend.purchase_applications.change_status'))
                ->color('info')
                ->icon('heroicon-o-arrow-path')
                ->modalWidth('lg')
                ->form([
                    Select::make('status')
                        ->label(__('backend.purchase_applications.status'))
                        ->options(PurchaseApplicationStatus::class)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => $data['status']]);
                    Notification::make()
                        ->title(__('backend.purchase_applications.status_changed'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
