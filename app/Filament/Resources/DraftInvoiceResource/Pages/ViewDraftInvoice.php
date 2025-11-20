<?php

namespace App\Filament\Resources\DraftInvoiceResource\Pages;

use App\Filament\Resources\DraftInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDraftInvoice extends ViewRecord
{
    protected static string $resource = DraftInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn () => DraftInvoiceResource::getUrl('print', ['record' => $this->record]))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->status === 'final'),
            Actions\Action::make('download_pdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('filament.admin.resources.draft-invoices.download-pdf', ['id' => $this->record->id]))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->status === 'final'),
        ];
    }
}
