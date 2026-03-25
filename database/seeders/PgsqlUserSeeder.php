<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PgsqlUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Johnny Demadara',
                'email' => 'jrdemadara@protonmail.com',
                'password' => 'E=mc2',
            ],
            [
                'name' => 'Azitsorog Inc',
                'email' => 'azitsoroginc@yahoo.com',
                'password' => 'E=mc2',
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                ]
            );
        }
    }
}
