<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Polo Dev',
            'email' => 'polodev10@gmail.com',
            'password' => bcrypt('hello123'),
        ]);

        User::factory()->create([
            'name' => 'Mobile User',
            'email' => '01616806528@mobile.local',
            'mobile' => '01616806528',
            'password' => bcrypt('123456'),
        ]);
    }
}
