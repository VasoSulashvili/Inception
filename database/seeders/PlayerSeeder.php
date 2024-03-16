<?php

namespace Database\Seeders;

use App\Models\Player\Player;
use App\Models\Player\Rank;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Player::factory()->create([
            "username" => "test1",
            "first_name" => "test",
            "last_name" => "person",
            "gender" => "male",
            "lang" => "en",
            "email" => "testPlayer@gmail.com",
            "rank_id" => Rank::factory()->create()->id,
            "password" => bcrypt('password'),
            "balance" => 0.0000,
            "is_blocked" => 0,
        ]);

        Player::factory(9)->create();
        Rank::factory(2)->create();
    }
}
