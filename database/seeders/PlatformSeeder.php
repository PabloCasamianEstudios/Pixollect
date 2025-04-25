<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'PC', 'description' => 'Personal computers running Windows, macOS or Linux.'],
            ['name' => 'PlayStation', 'description' => 'Sony’s console family (PS1 to PS5).'],
            ['name' => 'Xbox', 'description' => 'Microsoft’s console family (Xbox, Xbox 360, One, Series X/S).'],
            ['name' => 'Nintendo Switch', 'description' => 'Nintendo’s hybrid console.'],
            ['name' => 'Mobile', 'description' => 'Smartphones and tablets (iOS, Android).'],
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}
