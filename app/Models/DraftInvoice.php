<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftInvoice extends Model
{
    use SoftDeletes;
    protected $connection = 'pgsql_main';
    
    protected $fillable = [
        'si_number',
        'type',
        'date',
        'terms',
        'total_amount',
        'client_id',
        'vatable_sales',
        'vat',
        'vat_exempt_sales',
        'zero_rated_sales',
        'total_sales_vat_inclusive',
        'less_vat',
        'amount_net_of_vat',
        'discount',
        'discount_id_number',
        'add_vat',
        'withholding_tax',
        'total_amount_due',
        'printed_name',
        'status',
        'soft_copies',
    ];

    protected $casts = [
        'date' => 'date',
        'total_amount' => 'decimal:2',
        'vatable_sales' => 'decimal:2',
        'vat' => 'decimal:2',
        'vat_exempt_sales' => 'decimal:2',
        'zero_rated_sales' => 'decimal:2',
        'total_sales_vat_inclusive' => 'decimal:2',
        'less_vat' => 'decimal:2',
        'amount_net_of_vat' => 'decimal:2',
        'discount' => 'decimal:2',
        'add_vat' => 'decimal:2',
        'withholding_tax' => 'decimal:2',
        'total_amount_due' => 'decimal:2',
        'soft_copies' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'draft_invoice_id');
    }

    public function salesInvoice()
    {
        return $this->hasOne(SalesInvoice::class, 'draft_invoice_id');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isFinal(): bool
    {
        return $this->status === 'final';
    }
}
