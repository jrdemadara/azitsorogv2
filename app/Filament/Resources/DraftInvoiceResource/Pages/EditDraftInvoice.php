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
            Actions\DeleteAction::make(),
        ];
    }
}
