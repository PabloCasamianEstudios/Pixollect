<?php

namespace Database\Seeders;

use App\Models\Saga;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sagas = [
            ['name' => 'Super Mario', 'description' => ''],
            ['name' => 'The Legend of Zelda', 'description' => ''],

        ];

        foreach ($sagas as $saga) {
            Saga::create($saga);
        }
    }
}
