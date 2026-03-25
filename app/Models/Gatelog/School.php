<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];
}
