<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rankIds = Rank::all()->pluck('id')->toArray();
        Player::factory()->create([
            "username" => "test1",
            "first_name" => "test",
            "last_name" => "person",
            "gender" => "male",
            "lang" => "en",
            "email" => "testPlayer@gmail.com",
            "rank_id" => $rankIds[0],
            "password" => bcrypt('password'),
            "balance" => 0.0000,
            "is_blocked" => 0,
        ]);
        for ($i = 1; $i < count($rankIds); $i++)
        {
            Player::factory()->create(['rank_id' => $rankIds[$i]]);
        }
    }
}
