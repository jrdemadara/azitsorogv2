<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class ParentDevice extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'user_id',
        'platform',
        'push_token',
        'last_seen_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
