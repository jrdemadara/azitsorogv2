<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftInvoice extends Model
{
    protected $connection = 'pgsql_main';
    protected $fillable = [
        'si_number',
        'type',
        'total_amount',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'draft_invoice_id');
    }
}
