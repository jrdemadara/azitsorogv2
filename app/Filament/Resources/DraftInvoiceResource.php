<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DraftInvoiceResource\Pages;
use App\Filament\Resources\DraftInvoiceResource\RelationManagers\InvoiceItemsRelationManager;
use App\Models\DraftInvoice;
use App\Models\InventoryMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Repeater;
use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DraftInvoiceResource extends Resource
{
    protected static ?string $model = DraftInvoice::class;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    protected static ?string $navigationLabel = "Invoices";

    protected static ?string $modelLabel = "Invoice";

    protected static ?string $pluralModelLabel = "Invoices";

    protected static ?string $navigationGroup = "Management";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Invoice Information")->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make("si_number")
                        ->label("SI Number")
                        ->required()
                        ->numeric()
                        ->unique(ignoreRecord: true)
                        ->default(fn() => DraftInvoice::max("si_number") + 1 ?? 32001),
                    Forms\Components\Select::make("type")
                        ->label("Invoice Type")
                        ->options([
                            "cash" => "Cash Sales",
                            "charge" => "Charge Sales",
                        ])
                        ->required()
                        ->default("cash"),
                    Forms\Components\DatePicker::make("date")
                        ->label("Date")
                        ->required()
                        ->default(now())
                        ->displayFormat("F d, Y"),
                    Forms\Components\TextInput::make("terms")->label("Terms")->maxLength(255),
                ]),
            ]),
            Forms\Components\Section::make("Client Information")->schema([
                Forms\Components\Grid::make(4)->schema([
                    Forms\Components\Select::make("client_id")
                        ->label("Client")
                        ->relationship("client", "name")
                        ->required()
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            if ($state) {
                                $client = \App\Models\Client::find($state);
                                if ($client) {
                                    $set("client_name", $client->name);
                                    $set("client_tin", $client->tin);
                                    $set("client_address", $client->address);
                                    if ($client->terms) {
                                        $set("terms", $client->terms);
                                    }
                                }
                            }
                        }),
                    Forms\Components\Placeholder::make("client_name")
                        ->label("Registered Name")
                        ->content(
                            fn(Forms\Get $get) => \App\Models\Client::find($get("client_id"))
                                ?->name ?? "—",
                        ),
                    Forms\Components\Placeholder::make("client_tin")
                        ->label("TIN")
                        ->content(
                            fn(Forms\Get $get) => \App\Models\Client::find($get("client_id"))
                                ?->tin ?? "—",
                        ),
                    Forms\Components\Placeholder::make("client_address")
                        ->label("Address")
                        ->content(
                            fn(Forms\Get $get) => \App\Models\Client::find($get("client_id"))
                                ?->address ?? "—",
                        ),
                ]),
            ]),
            Forms\Components\Section::make("Tax & Totals")->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make("total_amount")
                        ->label("Gross Amount")
                        ->prefix("₱")
                        ->readOnly()
                        ->dehydrated()
                        ->reactive()
                        ->dehydrateStateUsing(
                            fn($state) => $state === null
                                ? null
                                : (float) str_replace(",", "", (string) $state),
                        ),
                    Forms\Components\TextInput::make("vatable_sales")
                        ->label("VATable Sales")
                        ->prefix("₱")
                        ->readOnly()
                        ->dehydrated()
                        ->reactive()
                        ->dehydrateStateUsing(
                            fn($state) => $state === null
                                ? null
                                : (float) str_replace(",", "", (string) $state),
                        ),
                    Forms\Components\TextInput::make("vat")
                        ->label("VAT (12%)")
                        ->prefix("₱")
                        ->readOnly()
                        ->dehydrated()
                        ->reactive()
                        ->dehydrateStateUsing(
                            fn($state) => $state === null
                                ? null
                                : (float) str_replace(",", "", (string) $state),
                        ),
                ]),
            ]),
            Forms\Components\Section::make("Invoice Items")->schema([
                Repeater::make("items")
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make("product_id")
                            ->label("Product")
                            ->relationship("product", "name")
                            ->getOptionLabelFromRecordUsing(
                                fn(Product $record) => $record->sku . " - " . $record->name,
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $product = Product::find($get("product_id"));
                                if ($product) {
                                    $set("item_name", $product->name);
                                    $set(
                                        "unit_cost",
                                        $product->unit_price ?? ($product->unit_cost ?? 0),
                                    );
                                }
                                $qty = $get("quantity");
                                if ($qty === null) {
                                    $qty = 1;
                                    $set("quantity", $qty);
                                }
                                $qty = (float) $qty;
                                $unit = (float) ($get("unit_cost") ?? 0);
                                $set("amount", $qty * $unit);
                            }),
                        Forms\Components\Textarea::make("item_name")
                            ->label("Item Description / Nature of Service")
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make("quantity")
                                ->label("Quantity")
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->minValue(0)
                                ->step(1)
                                ->live(debounce: 300)
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $quantity = (float) $state;
                                    $unitCost = (float) ($get("unit_cost") ?? 0);
                                    $set("amount", $quantity * $unitCost);
                                    self::updateTotalsFromItems(
                                        $get("../../../items") ??
                                            ($get("../../items") ??
                                                ($get("../items") ?? ($get("items") ?? []))),
                                        $set,
                                        $get,
                                    );
                                }),
                            Forms\Components\TextInput::make("unit_cost")
                                ->label("Unit Cost")
                                ->required()
                                ->numeric()
                                ->prefix("₱")
                                ->minValue(0)
                                ->step(0.01)
                                ->dehydrateStateUsing(
                                    fn($state) => $state === null
                                        ? null
                                        : (float) str_replace(",", "", (string) $state),
                                )
                                ->live(debounce: 300)
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $quantity = (float) ($get("quantity") ?? 0);
                                    $unitCost = (float) $state;
                                    $set("amount", $quantity * $unitCost);
                                    self::updateTotalsFromItems(
                                        $get("../../../items") ??
                                            ($get("../../items") ??
                                                ($get("../items") ?? ($get("items") ?? []))),
                                        $set,
                                        $get,
                                    );
                                }),
                            Forms\Components\TextInput::make("amount")
                                ->label("Amount")
                                ->numeric()
                                ->prefix("₱")
                                ->disabled()
                                ->dehydrated()
                                ->default(0)
                                ->formatStateUsing(
                                    fn($state) => $state === null
                                        ? null
                                        : number_format((float) $state, 2, ".", ","),
                                ),
                        ]),
                    ])
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (?array $state, Set $set, Get $get) {
                        self::updateTotalsFromItems($state ?? [], $set, $get);
                    })
                    ->collapsible()
                    ->defaultItems(0),
            ]),
            Forms\Components\Section::make("Soft Copies")->schema([
                Forms\Components\FileUpload::make("soft_copies")
                    ->label("Upload Scanned Invoices (PDF or Images)")
                    ->multiple()
                    ->acceptedFileTypes(["application/pdf", "image/jpeg", "image/png", "image/jpg"])
                    ->disk("local")
                    ->directory("invoices/soft-copies")
                    ->downloadable()
                    ->previewable()
                    ->openable()
                    ->deletable()
                    ->maxSize(10240)
                    ->helperText(
                        "Drag and drop files here or click to browse. Multiple files allowed. PDF and images only (max 10MB per file).",
                    )
                    ->columnSpanFull(),
            ]),
            Forms\Components\Section::make("Finalization")
                ->schema([
                    Forms\Components\TextInput::make("printed_name")
                        ->label("Printed Name & Signature / Authorized Representative")
                        ->maxLength(255)
                        ->visible(fn($record) => $record && $record->status === "final"),
                    Forms\Components\Select::make("status")
                        ->label("Status")
                        ->options([
                            "draft" => "Draft",
                            "final" => "Final",
                        ])
                        ->default("draft")
                        ->required()
                        ->disabled(fn($record) => $record && $record->status === "final"),
                ])
                ->visible(fn($record) => $record !== null),
        ]);
    }

    private static function updateTotalsFromItems(array $items, Set $set, Get $get): void
    {
        $total = 0.0;
        foreach ($items as $item) {
            $qty = (float) ($item["quantity"] ?? 0);
            $unit = (float) ($item["unit_cost"] ?? 0);
            $total += $qty * $unit;
        }

        $vatable = $total / 1.12;
        $vat = $vatable * 0.12;

        $newTotal = number_format(round($total, 2), 2, ".", ",");
        $newVatable = number_format(round($vatable, 2), 2, ".", ",");
        $newVat = number_format(round($vat, 2), 2, ".", ",");

        $set("total_amount", $newTotal);
        $set("vatable_sales", $newVatable);
        $set("vat", $newVat);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("si_number")
                    ->label("SI Number")
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("client.name")
                    ->label("Client")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make("type")
                    ->label("Type")
                    ->formatStateUsing(
                        fn($state) => $state === "cash" ? "Cash Sales" : "Charge Sales",
                    )
                    ->colors([
                        "success" => "cash",
                        "warning" => "charge",
                    ]),
                Tables\Columns\TextColumn::make("date")->label("Date")->date("F d, Y")->sortable(),
                Tables\Columns\TextColumn::make("total_amount")
                    ->label("Gross Amount")
                    ->money("PHP")
                    ->sortable(),
                Tables\Columns\BadgeColumn::make("status")
                    ->label("Status")
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->colors([
                        "gray" => "draft",
                        "success" => "final",
                    ]),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make("status")->options([
                    "draft" => "Draft",
                    "final" => "Final",
                ]),
                SelectFilter::make("type")
                    ->label("Invoice Type")
                    ->options([
                        "cash" => "Cash Sales",
                        "charge" => "Charge Sales",
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make("convert_to_final")
                    ->label("Convert to Final")
                    ->icon("heroicon-o-check-circle")
                    ->color("success")
                    ->requiresConfirmation()
                    ->action(function (DraftInvoice $record) {
                        $items = $record->items()->with("product")->get();

                        if ($items->isEmpty()) {
                            Notification::make()
                                ->title("No invoice items found.")
                                ->danger()
                                ->send();
                            return;
                        }

                        foreach ($items as $item) {
                            if (!$item->product) {
                                Notification::make()
                                    ->title("Missing product on an invoice item.")
                                    ->body(
                                        "Please select a product for each item before finalizing.",
                                    )
                                    ->danger()
                                    ->send();
                                return;
                            }

                            if ($item->product->stock_on_hand < (int) $item->quantity) {
                                Notification::make()
                                    ->title("Insufficient stock for: " . $item->product->name)
                                    ->body(
                                        "Available: " .
                                            $item->product->stock_on_hand .
                                            ", required: " .
                                            (int) $item->quantity,
                                    )
                                    ->danger()
                                    ->send();
                                return;
                            }
                        }

                        DB::connection("pgsql_main")->transaction(function () use (
                            $record,
                            $items,
                        ) {
                            $record->update(["status" => "final"]);

                            foreach ($items as $item) {
                                $product = $item->product;
                                $qty = (int) $item->quantity;

                                InventoryMovement::create([
                                    "product_id" => $product->id,
                                    "quantity" => -$qty,
                                    "type" => "sale",
                                    "source_type" => DraftInvoice::class,
                                    "source_id" => $record->id,
                                    "notes" => "Invoice " . $record->si_number,
                                    "occurred_at" => now(),
                                ]);
                            }
                        });

                        Notification::make()
                            ->title("Invoice finalized and stock updated.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn(DraftInvoice $record) => $record->status === "draft"),
                Tables\Actions\Action::make("print")
                    ->label("Print")
                    ->icon("heroicon-o-printer")
                    ->url(
                        fn(DraftInvoice $record) => DraftInvoiceResource::getUrl("print", [
                            "record" => $record,
                        ]),
                    )
                    ->openUrlInNewTab()
                    ->visible(fn(DraftInvoice $record) => $record->status === "final"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort("created_at", "desc");
    }

    public static function getRelations(): array
    {
        return [InvoiceItemsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListDraftInvoices::route("/"),
            "create" => Pages\CreateDraftInvoice::route("/create"),
            "view" => Pages\ViewDraftInvoice::route("/{record}"),
            "edit" => Pages\EditDraftInvoice::route("/{record}/edit"),
            "print" => Pages\PrintInvoice::route("/{record}/print"),
        ];
    }
}
