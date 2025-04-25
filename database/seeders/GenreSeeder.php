<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Adventure', 'description' => 'Exploration-heavy with narrative and puzzles.'],
            ['name' => 'Arcade', 'description' => ''],
            ['name' => 'Card & Board Game', 'description' => ''],
            ['name' => 'Fighting', 'description' => ''],
            ['name' => 'Hack ans Slash', 'description' => ''],
            ['name' => 'Indie', 'description' => ''],
            ['name' => 'MOBA', 'description' => ''],
            ['name' => 'Music', 'description' => ''],
            ['name' => 'Pinball', 'description' => ''],
            ['name' => 'Platform', 'description' => ''],
            ['name' => 'Point-and-Click', 'description' => ''],
            ['name' => 'Puzzle', 'description' => ''],
            ['name' => 'Quiz/Trivia', 'description' => ''],
            ['name' => 'Racing', 'description' => ''],
            ['name' => 'Real Time Strategy (RTS)', 'description' => ''],
            ['name' => 'RPG', 'description' => 'Character development, story-driven, and quests.'],
            ['name' => 'Shooter', 'description' => ''],
            ['name' => 'Simulation', 'description' => 'Realistic systems and life-like gameplay.'],
            ['name' => 'Sport', 'description' => ''],
            ['name' => 'Strategy', 'description' => 'Tactical thinking and planning.'],
            ['name' => 'Tactical', 'description' => ''],
            ['name' => 'Turn-based Strategy', 'description' => ''],
            ['name' => 'Visual Novel', 'description' => ''],
            ['name' => 'Roguelike', 'description' => ''],

        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
