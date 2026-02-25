<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EventSeeder::class,
            RoomSeeder::class,
            CategorySeeder::class,
            SpeakerSeeder::class,
            SessionSeeder::class,
        ]);
    }
}
