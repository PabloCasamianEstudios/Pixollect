<?php

namespace Database\Seeders;

use App\Models\GameMode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = [
            ['name' => 'Single Player', 'description' => 'Play alone in a story or experience.'],
            ['name' => 'Multiplayer', 'description' => 'Play with or against other players online or locally.'],
            ['name' => 'Co-op', 'description' => 'Team up with others to complete objectives together.'],
            ['name' => 'MMO', 'description' => 'Massively Multiplayer Online, persistent world with thousands of players.'],
        ];

        foreach ($modes as $mode) {
            GameMode::create($mode);
        }
    }
}
