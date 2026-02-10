<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'pgsql_main';

    protected $fillable = [
        'sku',
        'name',
        'unit_cost',
        'unit_price',
        'stock_on_hand',
        'is_active',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'stock_on_hand' => 'integer',
        'is_active' => 'boolean',
    ];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
