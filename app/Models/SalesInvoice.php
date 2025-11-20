<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{

    protected $connection = 'pgsql_main';
    protected $fillable = [
        'si_number',
        'invoice',
        'deposit_slip',
        'client_id',
        'draft_invoice_id',
    ];

    public function draftInvoice()
    {
        return $this->belongsTo(DraftInvoice::class);
    }
}
