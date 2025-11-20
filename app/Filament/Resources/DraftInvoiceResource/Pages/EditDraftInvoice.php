<?php

namespace App\Filament\Resources\DraftInvoiceResource\Pages;

use App\Filament\Resources\DraftInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDraftInvoice extends EditRecord
{
    protected static string $resource = DraftInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\Action::make('convert_to_final')
                ->label('Convert to Final')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Convert Invoice to Final')
                ->modalDescription('Are you sure you want to convert this invoice to final? This action cannot be undone.')
                ->action(function () {
                    $this->record->update(['status' => 'final']);
                    $this->notification()
                        ->success()
                        ->title('Invoice converted to final')
                        ->body('The invoice has been successfully converted to final status.')
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'draft'),
            Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn () => DraftInvoiceResource::getUrl('print', ['record' => $this->record]))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->status === 'final'),
            Actions\DeleteAction::make(),
        ];
    }
}
