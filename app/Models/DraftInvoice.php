<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftInvoice extends Model
{
    use SoftDeletes;
    protected $connection = "pgsql_main";

    protected $fillable = [
        "si_number",
        "type",
        "date",
        "terms",
        "total_amount",
        "client_id",
        "vatable_sales",
        "vat",
        "printed_name",
        "status",
        "soft_copies",
    ];

    protected $casts = [
        "date" => "date",
        "total_amount" => "decimal:2",
        "vatable_sales" => "decimal:2",
        "vat" => "decimal:2",
        "soft_copies" => "array",
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, "draft_invoice_id");
    }

    public function salesInvoice()
    {
        return $this->hasOne(SalesInvoice::class, "draft_invoice_id");
    }

    public function isDraft(): bool
    {
        return $this->status === "draft";
    }

    public function isFinal(): bool
    {
        return $this->status === "final";
    }
}
