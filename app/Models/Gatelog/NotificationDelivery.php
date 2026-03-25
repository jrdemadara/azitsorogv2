<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class NotificationDelivery extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'gate_log_id',
        'user_id',
        'parent_device_id',
        'status',
        'provider_message',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'delivered_at' => 'datetime',
        ];
    }
}
