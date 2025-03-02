<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DraftInvoiceResource\Pages;
use App\Models\DraftInvoice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Torgodly\Html2Media\Tables\Actions\Html2MediaAction;

class DraftInvoiceResource extends Resource
{
    protected static ?string $model = DraftInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Draft Invoice';

    public static function getNavigationGroup(): ?string
    {
        return 'Invoice';
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('si_number')
                    ->label('SI Number')
                    ->required()
                    ->maxLength(255),

                TextInput::make('type')
                    ->label('Invoice Type')
                    ->required()
                    ->maxLength(255),

                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'name') // Assuming 'name' is the client's name column
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('si_number')
                    ->label('SI Number')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Invoice Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->sortable()
                    ->money('PHP'),

                TextColumn::make('client.name')
                    ->label('Client')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->sortable()
                    ->dateTime('Y-m-d H:i'),

            ])
            ->filters([
            ])
            ->actions([
                Html2MediaAction::make('print')
                    ->icon('heroicon-o-printer')
                    ->filename(fn($record) => 'invoice_' . $record->si_number . '.pdf')
                    ->print(true)
                    ->color('success')
                    ->preview()->content(fn($record) => view('printables/invoice', [
                        'record' => $record->load('items')
                    ])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDraftInvoices::route('/'),
            'create' => Pages\CreateDraftInvoice::route('/create'),
            'edit' => Pages\EditDraftInvoice::route('/{record}/edit'),
        ];
    }
}
