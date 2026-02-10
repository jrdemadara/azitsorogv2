<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryMovementResource\Pages;
use App\Models\InventoryMovement;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryMovementResource extends Resource
{
    protected static ?string $model = InventoryMovement::class;

    protected static ?string $navigationIcon = "heroicon-o-arrows-up-down";

    protected static ?string $navigationGroup = "Management";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("product_id")
                    ->label("Product")
                    ->relationship("product", "name")
                    ->getOptionLabelFromRecordUsing(
                        fn(Product $record) => $record->sku . " - " . $record->name,
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make("type")
                    ->label("Type")
                    ->options([
                        "receipt" => "Receipt",
                        "adjustment" => "Adjustment",
                        "return" => "Return",
                    ])
                    ->required(),
                TextInput::make("quantity")
                    ->label("Quantity")
                    ->numeric()
                    ->required()
                    ->helperText("Use negative numbers to reduce stock."),
                DateTimePicker::make("occurred_at")
                    ->label("Occurred At")
                    ->default(now())
                    ->required(),
                Textarea::make("notes")->label("Notes")->rows(2)->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("product.sku")->label("SKU")->searchable()->sortable(),
                TextColumn::make("product.name")->label("Product")->searchable()->sortable(),
                TextColumn::make("type")->label("Type")->sortable(),
                TextColumn::make("quantity")->label("Qty")->sortable(),
                TextColumn::make("occurred_at")->label("Occurred At")->dateTime("Y-m-d H:i"),
                TextColumn::make("notes")->label("Notes")->limit(40),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\ViewAction::make()])
            ->bulkActions([]);
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
            "index" => Pages\ListInventoryMovements::route("/"),
            "create" => Pages\CreateInventoryMovement::route("/create"),
        ];
    }
}
