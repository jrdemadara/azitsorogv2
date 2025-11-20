<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SalesInvoiceResource\Pages;
use App\Models\SalesInvoice;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\URL;

class SalesInvoiceResource extends Resource
{
    protected static ?string $model           = SalesInvoice::class;
    protected static ?string $navigationLabel = 'Sales Invoices';
    protected static ?string $navigationIcon  = 'heroicon-o-document-duplicate';
    protected static ?int $navigationSort     = 3;
    
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hide from navigation as soft copies are now integrated into Invoice resource
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('draft_invoice_id')
                    ->label('Draft Invoice')
                    ->relationship('draftInvoice', 'si_number')
                    ->searchable()
                    ->preload()
                    ->required(),

                Grid::make(2) // 👈 Arrange the next two fields in one row
                    ->schema([
                        FileUpload::make('invoice')
                            ->label('Invoice Image')
                            ->image()
                            ->disk('local')
                            ->directory('invoices')
                            ->maxSize(2048)
                            ->required(),

                        FileUpload::make('deposit_slip')
                            ->label('Deposit Slip')
                            ->image()
                            ->disk('local')
                            ->directory('deposit-slip')
                            ->maxSize(2048)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('draftInvoice.si_number')
                    ->label('Draft Invoice')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('draftInvoice.client.name')
                    ->label('Client')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('invoice')
                    ->label('Invoice')
                    ->getStateUsing(fn($record) => URL::route('secure.file', [
                        'type'     => 'invoice',
                        'filename' => basename($record->invoice), // Extract actual file name
                    ])),

                ImageColumn::make('deposit_slip')
                    ->label('Deposit Slip')
                    ->getStateUsing(fn($record) => URL::route('secure.file', [
                        'type'     => 'deposit-slip',
                        'filename' => basename($record->deposit_slip), // Extract actual file name
                    ])),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListSalesInvoices::route('/'),
            'create' => Pages\CreateSalesInvoice::route('/create'),
            'edit'   => Pages\EditSalesInvoice::route('/{record}/edit'),
        ];
    }
}
