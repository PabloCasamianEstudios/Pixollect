<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            ['name' => 'Fantasy', 'description' => 'Magical settings, mythical creatures, and epic quests.'],
            ['name' => 'Sci-Fi', 'description' => 'Futuristic settings with advanced technology.'],
            ['name' => 'Post-Apocalyptic', 'description' => 'Aftermath of catastrophic events.'],
            ['name' => 'Cyberpunk', 'description' => 'High-tech, low-life dystopian future.'],
            ['name' => 'Historical', 'description' => 'Based on real historical settings and events.'],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
