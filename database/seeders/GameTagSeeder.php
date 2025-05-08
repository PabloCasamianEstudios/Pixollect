<?php

namespace Database\Seeders;

use App\Models\Saga;
use App\Models\Genre;
use App\Models\Theme;
use App\Models\GameTag;
use App\Models\GameMode;
use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$tags = [
            // plataformas
            ['name' => 'PC'],
            ['name' => 'Mac'],
            ['name' => 'Linux'],
            ['name' => 'PlayStation'],
            ['name' => 'PlayStation 2'],
            ['name' => 'PlayStation 3'],
            ['name' => 'PlayStation 4'],
            ['name' => 'PlayStation 5'],
            ['name' => 'Xbox'],
            ['name' => 'Xbox 360'],
            ['name' => 'Xbox One'],
            ['name' => 'Xbox Series X/S'],
            ['name' => 'Nintendo Switch'],
            ['name' => 'Nintendo Wii'],
            ['name' => 'Nintendo Wii U'],
            ['name' => 'Nintendo DS'],
            ['name' => 'Nintendo 3DS'],
            ['name' => 'Game Boy'],
            ['name' => 'Game Boy Advance'],
            ['name' => 'PSP'],
            ['name' => 'PS Vita'],
            ['name' => 'Android'],
            ['name' => 'iOS'],
            ['name' => 'Web Browser'],
            ['name' => 'Arcade'],
            ['name' => 'Dreamcast'],
            ['name' => 'Sega Genesis'],
            ['name' => 'Other'],

            // modos
            ['name' => 'Single Player', 'description' => 'A game mode that supports only one player (online or offline).'],
            ['name' => 'Split Screen', 'description' => 'The game can be played by multiple players at the same time on the same screen.'],
            ['name' => 'Co-Operative (Co-Op)', 'description' => 'Players work together as teammates against computer-controlled opponents.'],
            ['name' => 'Multiplayer', 'description' => 'Supports multiple players playing together online or offline.'],
            ['name' => 'Battle Royale', 'description' => 'Online multiplayer mode blending survival, exploration, and last-man-standing gameplay.'],
            ['name' => 'Massively Multiplayer Online (MMO)', 'description' => 'Supports large numbers of players simultaneously in a virtual world.'],
            // géneros
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

            // temas
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
            ['name' => 'Roguelike', 'description' => '']

            // sagas
            ['name' => 'Super Mario', 'description' => ''],
            ['name' => 'The Legend of Zelda', 'description' => ''],
        ];

        foreach ($tags as $tag) {
            GameTag::create($tag);
        }*/
        $sources = collect()
        ->merge(Genre::all()->pluck('name'))
        ->merge(Theme::all()->pluck('name'))
        ->merge(Platform::all()->pluck('name'))
        ->merge(GameMode::all()->pluck('name'))
        ->merge(Saga::all()->pluck('name'))
        ->unique();
        foreach ($sources as $name) {
            GameTag::firstOrCreate(['name' => $name], ['description' => null]);
        }
    }
}
