<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create dummy foosball games
        Game::factory(100)->create();
        //Player::factory()->create();

        // Generate player names
        $names = ['andy','max','pietro','sophie','alex','david'];
        foreach ($names as $name) {
            Player::create(['name'=>$name]);
        }
    }
}
