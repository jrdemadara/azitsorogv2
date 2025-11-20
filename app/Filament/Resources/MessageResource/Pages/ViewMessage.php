<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label('Reply')
                ->icon('heroicon-o-envelope')
                ->url(fn () => "mailto:{$this->record->email}?subject=" . urlencode("Re: Message from {$this->record->fullname}"))
                ->openUrlInNewTab(),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Mark as read when viewing for the first time
        if (!$this->record->is_read) {
            $this->record->update(['is_read' => true]);
            $this->record->refresh();
        }
    }
}

