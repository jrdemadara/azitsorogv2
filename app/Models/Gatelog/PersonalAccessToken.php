<?php

namespace App\Models\Gatelog;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $connection = 'pgsql_gatelog';

    protected $table = 'personal_access_tokens';
}
