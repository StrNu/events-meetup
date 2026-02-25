<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@eventflow.test',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@eventflow.test',
            'password' => 'password',
        ]);
    }
}
