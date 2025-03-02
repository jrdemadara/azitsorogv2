<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceItemsResource\Pages;
use App\Models\InvoiceItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoiceItemsResource extends Resource
{
    protected static ?string $model = InvoiceItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationGroup(): ?string
    {
        return 'Invoice';
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('item_name')
                    ->label('Item Name')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        Self::calculateTotal($get, $set);
                    }),

                TextInput::make('unit_cost')
                    ->label('Unit Cost')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->prefix('₱')
                    ->required()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        Self::calculateTotal($get, $set);
                    }),

                TextInput::make('amount')
                    ->label('Total Amount')
                    ->numeric()
                    ->required()
                    ->readOnly(true)
                    ->prefix('₱'),

                Select::make('draft_invoice_id')
                    ->label('Invoice')
                    ->relationship('draftInvoice', 'si_number') // Shows invoice SI number
                    ->searchable()
                    ->preload()
                    ->required(),
            ])
            ->columns(2); // Organizes fields into two columns

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item_name')
                    ->label('Item Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),

                TextColumn::make('unit_cost')
                    ->label('Unit Cost')
                    ->sortable()
                    ->money('PHP'),

                TextColumn::make('amount')
                    ->label('Total Amount')
                    ->sortable()
                    ->money('PHP'),

                TextColumn::make('draftInvoice.si_number') // Show related invoice
                ->label('Invoice')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListInvoiceItems::route('/'),
            'create' => Pages\CreateInvoiceItems::route('/create'),
            'edit' => Pages\EditInvoiceItems::route('/{record}/edit'),
        ];
    }

    public static function calculateTotal(Get $get, Set $set): void
    {
        $set('amount', $get('quantity') * $get('unit_cost'));
    }
}
