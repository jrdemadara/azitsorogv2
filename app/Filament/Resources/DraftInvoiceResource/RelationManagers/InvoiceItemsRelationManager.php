<?php

namespace App\Filament\Resources\DraftInvoiceResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = "items";

    protected static ?string $title = "Invoice Items";

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("product_id")
                ->label("Product")
                ->relationship("product", "name")
                ->getOptionLabelFromRecordUsing(
                    fn(Product $record) => $record->sku . " - " . $record->name,
                )
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                    $product = Product::find($state);
                    if ($product) {
                        $set("item_name", $product->name);
                        $set("unit_cost", $product->unit_price ?? ($product->unit_cost ?? 0));
                    }
                    $quantity = (float) ($get("quantity") ?? 0);
                    $unitCost = (float) ($get("unit_cost") ?? 0);
                    $set("amount", $quantity * $unitCost);
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
                    ->default(1)
                    ->minValue(0)
                    ->step(0.01)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        $quantity = (float) $state;
                        $unitCost = (float) ($get("unit_cost") ?? 0);
                        $set("amount", $quantity * $unitCost);
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
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        $quantity = (float) ($get("quantity") ?? 0);
                        $unitCost = (float) $state;
                        $set("amount", $quantity * $unitCost);
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
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("item_name")
            ->columns([
                Tables\Columns\TextColumn::make("product.sku")
                    ->label("SKU")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("item_name")
                    ->label("Item Description / Nature of Service")
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make("quantity")
                    ->label("Quantity")
                    ->numeric()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make("unit_cost")
                    ->label("Unit Cost")
                    ->money("PHP")
                    ->alignEnd(),
                Tables\Columns\TextColumn::make("amount")
                    ->label("Amount")
                    ->money("PHP")
                    ->alignEnd()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()->money("PHP")->label("Total"),
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function () {
                    $this->getOwnerRecord()->refresh();
                    $this->dispatch("refreshTotals");
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function () {
                    $this->getOwnerRecord()->refresh();
                    $this->dispatch("refreshTotals");
                }),
                Tables\Actions\DeleteAction::make()->after(function () {
                    $this->getOwnerRecord()->refresh();
                    $this->dispatch("refreshTotals");
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort("id");
    }
}
