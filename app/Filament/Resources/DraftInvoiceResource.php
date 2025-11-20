<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DraftInvoiceResource\Pages;
use App\Filament\Resources\DraftInvoiceResource\RelationManagers\InvoiceItemsRelationManager;
use App\Models\DraftInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DraftInvoiceResource extends Resource
{
    protected static ?string $model = DraftInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Invoices';

    protected static ?string $modelLabel = 'Invoice';

    protected static ?string $pluralModelLabel = 'Invoices';

    protected static ?string $navigationGroup = 'Invoice';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Invoice Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('si_number')
                                    ->label('SI Number')
                                    ->required()
                                    ->numeric()
                                    ->unique(ignoreRecord: true)
                                    ->default(fn () => DraftInvoice::max('si_number') + 1 ?? 32001),
                                Forms\Components\Select::make('type')
                                    ->label('Invoice Type')
                                    ->options([
                                        'cash' => 'Cash Sales',
                                        'charge' => 'Charge Sales',
                                    ])
                                    ->required()
                                    ->default('cash'),
                                Forms\Components\DatePicker::make('date')
                                    ->label('Date')
                                    ->required()
                                    ->default(now())
                                    ->displayFormat('F d, Y'),
                                Forms\Components\TextInput::make('terms')
                                    ->label('Terms')
                                    ->maxLength(255),
                            ]),
                    ]),
                Forms\Components\Section::make('Client Information')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $client = \App\Models\Client::find($state);
                                    if ($client) {
                                        $set('client_name', $client->name);
                                        $set('client_tin', $client->tin);
                                        $set('client_address', $client->address);
                                        if ($client->terms) {
                                            $set('terms', $client->terms);
                                        }
                                    }
                                }
                            }),
                        Forms\Components\Placeholder::make('client_name')
                            ->label('Registered Name')
                            ->content(fn (Forms\Get $get) => \App\Models\Client::find($get('client_id'))?->name ?? '—'),
                        Forms\Components\Placeholder::make('client_tin')
                            ->label('TIN')
                            ->content(fn (Forms\Get $get) => \App\Models\Client::find($get('client_id'))?->tin ?? '—'),
                        Forms\Components\Placeholder::make('client_address')
                            ->label('Address')
                            ->content(fn (Forms\Get $get) => \App\Models\Client::find($get('client_id'))?->address ?? '—'),
                    ]),
                Forms\Components\Section::make('Tax & Totals')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('vatable_sales')
                                    ->label('VATable Sales')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('vat')
                                    ->label('VAT')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('vat_exempt_sales')
                                    ->label('VAT-Exempt Sales')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('zero_rated_sales')
                                    ->label('Zero-Rated Sales')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('total_sales_vat_inclusive')
                                    ->label('Total Sales (VAT Inclusive)')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('less_vat')
                                    ->label('Less: VAT')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('amount_net_of_vat')
                                    ->label('Amount (Net of VAT)')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('discount')
                                    ->label('Less: Discount')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('discount_id_number')
                                    ->label('SC/PWD/NAAC/MOV/SP ID No.')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('add_vat')
                                    ->label('Add: VAT')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('withholding_tax')
                                    ->label('Less: Withholding Tax')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('total_amount_due')
                                    ->label('Total Amount Due')
                                    ->numeric()
                                    ->prefix('₱')
                                    ->step(0.01)
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Section::make('Soft Copies')
                    ->schema([
                        Forms\Components\FileUpload::make('soft_copies')
                            ->label('Upload Scanned Invoices (PDF or Images)')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                            ->disk('local')
                            ->directory('invoices/soft-copies')
                            ->downloadable()
                            ->previewable()
                            ->openable()
                            ->deletable()
                            ->maxSize(10240)
                            ->helperText('Drag and drop files here or click to browse. Multiple files allowed. PDF and images only (max 10MB per file).')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Finalization')
                    ->schema([
                        Forms\Components\TextInput::make('printed_name')
                            ->label('Printed Name & Signature / Authorized Representative')
                            ->maxLength(255)
                            ->visible(fn ($record) => $record && $record->status === 'final'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'final' => 'Final',
                            ])
                            ->default('draft')
                            ->required()
                            ->disabled(fn ($record) => $record && $record->status === 'final'),
                    ])
                    ->visible(fn ($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('si_number')
                    ->label('SI Number')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state === 'cash' ? 'Cash Sales' : 'Charge Sales')
                    ->colors([
                        'success' => 'cash',
                        'warning' => 'charge',
                    ]),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('F d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount_due')
                    ->label('Total Amount Due')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'final',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'final' => 'Final',
                    ]),
                SelectFilter::make('type')
                    ->label('Invoice Type')
                    ->options([
                        'cash' => 'Cash Sales',
                        'charge' => 'Charge Sales',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('convert_to_final')
                    ->label('Convert to Final')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (DraftInvoice $record) {
                        $record->update(['status' => 'final']);
                    })
                    ->visible(fn (DraftInvoice $record) => $record->status === 'draft'),
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (DraftInvoice $record) => DraftInvoiceResource::getUrl('print', ['record' => $record]))
                    ->openUrlInNewTab()
                    ->visible(fn (DraftInvoice $record) => $record->status === 'final'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            InvoiceItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDraftInvoices::route('/'),
            'create' => Pages\CreateDraftInvoice::route('/create'),
            'view' => Pages\ViewDraftInvoice::route('/{record}'),
            'edit' => Pages\EditDraftInvoice::route('/{record}/edit'),
            'print' => Pages\PrintInvoice::route('/{record}/print'),
        ];
    }
}
