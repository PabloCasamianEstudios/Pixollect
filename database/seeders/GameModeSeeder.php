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
            ['name' => 'Single Player', 'description' => 'A game mode that supports only one player (online or offline).'],
            ['name' => 'Split Screen', 'description' => 'The game can be played by multiple players at the same time on the same screen.'],
            ['name' => 'Co-Operative (Co-Op)', 'description' => 'Players work together as teammates against computer-controlled opponents.'],
            ['name' => 'Multiplayer', 'description' => 'Supports multiple players playing together online or offline.'],
            ['name' => 'Battle Royale', 'description' => 'Online multiplayer mode blending survival, exploration, and last-man-standing gameplay.'],
            ['name' => 'Massively Multiplayer Online (MMO)', 'description' => 'Supports large numbers of players simultaneously in a virtual world.'],
        ];

        foreach ($modes as $mode) {
            GameMode::create($mode);
        }
    }
}
