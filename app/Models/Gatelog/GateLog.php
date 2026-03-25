<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class GateLog extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'student_id',
        'direction',
        'logged_at',
        'gate_name',
        'source_ref',
        'push_notified',
        'push_notified_at',
    ];

    protected function casts(): array
    {
        return [
            'logged_at' => 'datetime',
            'push_notified' => 'boolean',
            'push_notified_at' => 'datetime',
        ];
    }
}
