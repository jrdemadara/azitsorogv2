<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class AllowedEmail extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'owner_name',
        'email',
        'is_used',
    ];
}
