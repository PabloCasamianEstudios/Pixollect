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
        ];


        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}
