<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'user_id',
        'student_id',
    ];
}
