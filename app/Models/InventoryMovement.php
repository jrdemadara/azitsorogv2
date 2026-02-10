<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $connection = "pgsql_main";

    protected $fillable = [
        "product_id",
        "quantity",
        "type",
        "source_type",
        "source_id",
        "notes",
        "occurred_at",
    ];

    protected $casts = [
        "occurred_at" => "datetime",
    ];

    protected static function booted(): void
    {
        static::created(function (InventoryMovement $movement) {
            if ($movement->product) {
                $movement->product->increment("stock_on_hand", $movement->quantity);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
