<?php

namespace App\Filament\Resources\DraftInvoiceResource\Pages;

use App\Filament\Resources\DraftInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDraftInvoices extends ListRecords
{
    protected static string $resource = DraftInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
