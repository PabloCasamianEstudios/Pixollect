<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // jueguitos things
            GenreSeeder::class,
            PlatformSeeder::class,
            GameModeSeeder::class,
            GameTagSeeder::class,
            ThemeSeeder::class,
            SagaSeeder::class,
        ]);
    }
}
