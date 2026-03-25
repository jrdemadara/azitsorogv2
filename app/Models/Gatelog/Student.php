<?php

namespace App\Models\Gatelog;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'pgsql_gatelog';

    protected $fillable = [
        'school_id',
        'student_id_number',
        'full_name',
        'is_active',
    ];
}
