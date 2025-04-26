<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // así no tengo que crearlo tol rato
        $admin = ['name' => 'admin', 'email'=>'admin@admin.com','password'=>'12345678', 'role' =>'admin'];
        User::create($admin);
        User::factory()->count(10)->create();
    }
}
