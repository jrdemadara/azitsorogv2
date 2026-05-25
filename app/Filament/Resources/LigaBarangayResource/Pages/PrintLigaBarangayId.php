<?php

namespace App\Filament\Resources\LigaBarangayResource\Pages;

use App\Filament\Resources\LigaBarangayResource;
use App\Models\LigaBarangay;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PrintLigaBarangayId extends Page
{
    protected static string $resource = LigaBarangayResource::class;

    protected static string $view = 'filament.resources.liga-barangay-resource.pages.print-id';

    public LigaBarangay $record;

    public string $photoDataUri = '';

    public string $signatureDataUri = '';
    public string $photoResolvedPath = '';
    public string $signatureResolvedPath = '';

    public function mount($record): void
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && !$user->isLigaPrinter())) {
            abort(403, 'Unauthorized to print Liga Barangay IDs.');
        }

        $this->record = LigaBarangay::query()
            ->whereKey($record)
            ->firstOr(function () use ($record) {
                abort(404, "LigaBarangay record {$record} not found on pgsql_lnb.profiles.");
            });

        $this->photoDataUri = $this->loadPrivateImageAsDataUri('profiles/' . ltrim((string) $this->record->photo, '/'), $this->photoResolvedPath);
        $this->signatureDataUri = $this->loadPrivateImageAsDataUri('signatures/' . ltrim((string) $this->record->signature, '/'), $this->signatureResolvedPath);
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

    private function loadPrivateImageAsDataUri(string $relativePath, string &$resolvedPath = ''): string
    {
        $disk = Storage::disk('external_storage');
        $relativePath = ltrim($relativePath, '/');
        $candidates = [
            $relativePath,
            'private/' . $relativePath,
        ];

        $foundPath = null;
        foreach ($candidates as $candidate) {
            if ($disk->exists($candidate)) {
                $foundPath = $candidate;
                break;
            }
        }

        if (!$foundPath) {
            $resolvedPath = '[missing] ' . implode(' OR ', $candidates);
            Log::warning('ID print image missing', [
                'disk' => 'external_storage',
                'root' => config('filesystems.disks.external_storage.root'),
                'relative' => $relativePath,
                'candidates' => $candidates,
                'record_id' => $this->record->id ?? null,
            ]);
            return '';
        }
        $resolvedPath = $foundPath;
        Log::info('ID print image found', [
            'disk' => 'external_storage',
            'path' => $foundPath,
            'record_id' => $this->record->id ?? null,
        ]);

        $bytes = $disk->get($foundPath);
        $mime = $this->mimeTypeFromPath($foundPath);

        return 'data:' . $mime . ';base64,' . base64_encode($bytes);
    }

    public function shouldShowDebugInfo(): bool
    {
        return App::isLocal() || config('app.debug');
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
