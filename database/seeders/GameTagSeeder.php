<?php

namespace Database\Seeders;

use App\Models\GameTag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Indie', 'description' => 'Developed by small or independent teams.'],
            ['name' => 'Retro', 'description' => 'Old-school style or classic remakes.'],
            ['name' => 'Pixel Art', 'description' => 'Games with pixelated visual style.'],
            ['name' => 'Narrative', 'description' => 'Story-focused experiences.'],
            ['name' => 'Competitive', 'description' => 'Designed around competition and ranking.'],
        ];

        foreach ($tags as $tag) {
            GameTag::create($tag);
        }
    }
}
