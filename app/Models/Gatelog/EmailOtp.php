<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'user_id',
        'email',
        'code_hash',
        'attempts',
        'expires_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }
}
