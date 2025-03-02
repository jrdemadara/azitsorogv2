<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'pgsql_main';
    protected $fillable   = [
        'name',
        'tin',
        'address',
        'terms',
    ];
}
