<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class StudentEmailAuthorization extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'student_id',
        'email',
    ];
}
