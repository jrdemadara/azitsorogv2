<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = "heroicon-o-cube";

    protected static ?string $navigationGroup = "Management";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("sku")
                    ->label("SKU")
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make("name")->label("Product Name")->required()->maxLength(255),
                TextInput::make("unit_cost")
                    ->label("Unit Cost")
                    ->numeric()
                    ->prefix("₱")
                    ->step(0.01)
                    ->dehydrateStateUsing(
                        fn($state) => $state === null
                            ? null
                            : (float) str_replace(",", "", (string) $state),
                    )
                    ->formatStateUsing(
                        fn($state) => $state === null
                            ? null
                            : number_format((float) $state, 2, ".", ","),
                    ),
                TextInput::make("unit_price")
                    ->label("Unit Price")
                    ->numeric()
                    ->prefix("₱")
                    ->step(0.01)
                    ->dehydrateStateUsing(
                        fn($state) => $state === null
                            ? null
                            : (float) str_replace(",", "", (string) $state),
                    )
                    ->formatStateUsing(
                        fn($state) => $state === null
                            ? null
                            : number_format((float) $state, 2, ".", ","),
                    ),
                TextInput::make("stock_on_hand")->label("Stock On Hand")->numeric()->default(0),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("sku")->label("SKU")->searchable()->sortable(),
                TextColumn::make("name")->label("Product")->searchable()->sortable(),
                TextColumn::make("stock_on_hand")->label("Stock")->sortable(),
                TextColumn::make("unit_price")->label("Unit Price")->money("PHP"),
                IconColumn::make("is_active")->label("Active")->boolean(),
                TextColumn::make("updated_at")
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
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
            "index" => Pages\ListProducts::route("/"),
            "create" => Pages\CreateProduct::route("/create"),
            "edit" => Pages\EditProduct::route("/{record}/edit"),
        ];
    }
}
