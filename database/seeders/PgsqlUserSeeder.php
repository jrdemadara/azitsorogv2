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
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Azitsorog Inc',
                'email' => 'azitsoroginc@yahoo.com',
                'password' => 'E=mc2',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'LNB Print',
                'email' => 'lnbprint',
                'password' => 'lnbspecialuser',
                'role' => User::ROLE_LIGA_PRINTER,
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                ]
            );
        }
    }
}
