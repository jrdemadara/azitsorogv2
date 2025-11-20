<?php

namespace App\Filament\Resources\DraftInvoiceResource\Pages;

use App\Filament\Resources\DraftInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\View;

class PrintInvoice extends Page
{
    protected static string $resource = DraftInvoiceResource::class;

    protected static string $view = 'filament.resources.draft-invoice-resource.pages.print-invoice';

    public $record;

    public function mount($record): void
    {
        $this->record = \App\Models\DraftInvoice::with(['client', 'items'])->findOrFail($record);
        
        if ($this->record->status !== 'final') {
            abort(403, 'Only final invoices can be printed.');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->action('window.print()'),
            Actions\Action::make('download_pdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->url(fn () => route('filament.admin.resources.draft-invoices.download-pdf', ['id' => $this->record->id]))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string
    {
        return 'Print Invoice #' . $this->record->si_number;
    }
}

