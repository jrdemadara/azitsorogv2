<?php

namespace App\Filament\Resources\LigaBarangayResource\Pages;

use App\Filament\Resources\LigaBarangayResource;
use App\Models\LigaBarangay;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class PrintLigaBarangayId extends Page
{
    protected static string $resource = LigaBarangayResource::class;

    protected static string $view = 'filament.resources.liga-barangay-resource.pages.print-id';

    public LigaBarangay $record;

    public string $photoDataUri = '';

    public string $signatureDataUri = '';

    public function mount($record): void
    {
        $this->record = LigaBarangay::findOrFail($record);
        $this->photoDataUri = $this->loadPrivateImageAsDataUri('profiles/' . ltrim((string) $this->record->photo, '/'));
        $this->signatureDataUri = $this->loadPrivateImageAsDataUri('signatures/' . ltrim((string) $this->record->signature, '/'));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->action(fn() => $this->dispatch('print-page')),
        ];
    }

    public function getTitle(): string
    {
        return 'Print ID #' . $this->record->id;
    }

    public function fullName(): string
    {
        $name = trim(implode(' ', array_filter([
            $this->record->firstname,
            $this->record->middlename,
            $this->record->lastname,
            $this->record->extension,
        ])));

        return $name !== '' ? $name : 'N/A';
    }

    public function birthdate(): string
    {
        if (!$this->record->birthdate) {
            return 'N/A';
        }

        return date('m/d/Y', strtotime((string) $this->record->birthdate));
    }

    public function validityPeriod(): string
    {
        $year = (string) ($this->record->year_elected ?? '');
        $term = (string) ($this->record->term ?? '');

        if ($year === '' && $term === '') {
            return 'N/A';
        }

        return trim($year . ' - ' . $term);
    }

    private function loadPrivateImageAsDataUri(string $relativePath): string
    {
        $disk = Storage::disk('external_storage');
        $path = 'private/' . ltrim($relativePath, '/');

        if (!$disk->exists($path)) {
            return '';
        }

        $bytes = $disk->get($path);
        $mime = $this->mimeTypeFromPath($path);

        return 'data:' . $mime . ';base64,' . base64_encode($bytes);
    }

    private function mimeTypeFromPath(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}
