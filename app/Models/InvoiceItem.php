<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $connection = "pgsql_main";
    protected $fillable = [
        "product_id",
        "item_name",
        "quantity",
        "unit_cost",
        "amount",
        "draft_invoice_id",
    ];

    public static function boot()
    {
        parent::boot();

        // When a new item is added
        static::created(function ($item) {
            $item->updateTotalAmount();
        });

        // When an item is updated
        static::updated(function ($item) {
            $item->updateTotalAmount();
        });

        // When an item is deleted
        static::deleted(function ($item) {
            $item->updateTotalAmount();
        });
    }

    public function draftInvoice()
    {
        return $this->belongsTo(DraftInvoice::class, "draft_invoice_id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Update total amount in the parent invoice.
     */
    public function updateTotalAmount(): void
    {
        if ($this->draftInvoice) {
            $total = $this->draftInvoice->items()->sum("amount"); // Sum all items
            $vatable = $total / 1.12;
            $vat = $vatable * 0.12;

            $this->draftInvoice->update([
                "total_amount" => $total,
                "vatable_sales" => round($vatable, 2),
                "vat" => round($vat, 2),
            ]);
        }
    }
}
