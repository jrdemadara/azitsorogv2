<?php

namespace App\Filament\Resources\LigaBarangayResource\Pages;

use App\Filament\Resources\LigaBarangayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLigaBarangay extends EditRecord
{
    protected static string $resource = LigaBarangayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
