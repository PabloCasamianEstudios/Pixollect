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
            ['name' => '4X', 'description' => 'Games where players control vast civilizations, exploring, expanding, exploiting, and exterminating.'],
            ['name' => 'Action', 'description' => 'Games emphasizing physical challenges like reaction time and coordination.'],
            ['name' => 'Business', 'description' => 'Simulations focusing on business concepts such as management and economy.'],
            ['name' => 'Comedy', 'description' => 'Games with humorous elements designed to entertain and amuse.'],
            ['name' => 'Drama', 'description' => 'Games with emotional storytelling that build tension and anticipation.'],
            ['name' => 'Educational', 'description' => 'Games designed to teach subjects or skills, or convey cultural or historical concepts.'],
            ['name' => 'Erotic', 'description' => 'Adult-themed games featuring nudity or sexual content.'],
            ['name' => 'Fantasy', 'description' => 'Games set in fictional worlds featuring magic and mythical creatures.'],
            ['name' => 'Historical', 'description' => 'Games set in or inspired by real historical periods and events.'],
            ['name' => 'Horror', 'description' => 'Games that aim to scare players through dark visuals and themes.'],
            ['name' => 'Kids', 'description' => 'Games designed specifically for young children, often family-friendly.'],
            ['name' => 'Mystery', 'description' => 'Games focused on solving crimes or unexplained events.'],
            ['name' => 'Non-fiction', 'description' => 'Games based on real people, places, and historical accuracy.'],
            ['name' => 'Open World', 'description' => 'Games with large maps offering free exploration and player autonomy.'],
            ['name' => 'Party', 'description' => 'Games for groups or social settings, often with simple and fast-paced gameplay.'],
            ['name' => 'Romance', 'description' => 'Games that feature romantic narratives and character relationships.'],
            ['name' => 'Sandbox', 'description' => 'Creative, open-ended games with minimal restrictions and no linear goals.'],
            ['name' => 'Science fiction', 'description' => 'Games set in futuristic or space-themed settings with advanced tech.'],
            ['name' => 'Stealth', 'description' => 'Games centered on avoiding detection, espionage, and strategic movement.'],
            ['name' => 'Survival', 'description' => 'Games focused on surviving in harsh environments with limited resources.'],
            ['name' => 'Thriller', 'description' => 'Games that build suspense and tension, often psychological in nature.'],
            ['name' => 'Warfare', 'description' => 'Games involving military combat, strategy, and large-scale battles.'],
            ['name' => 'Western', 'description' => 'Games inspired by the American Old West, with cowboys, duels, and frontier settings.'],
            ['name' => 'Superhero', 'description' => 'Games featuring characters with powers who protect society from threats.'],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
