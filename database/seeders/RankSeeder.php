<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i < 13; $i++)
        {
            if($i < 4) {
                $id = Group::where('name', \App\Enums\GroupType::WINNER->value)->first()->id;
            } elseif ($i > 3 && $i < 9) {
                $id = Group::where('name', \App\Enums\GroupType::RUNNER_UP->value)->first()->id;
            } else {
                $id = Group::where('name', \App\Enums\GroupType::OTHER->value)->first()->id;
            }

            Rank::factory()->create([
                'group_id' => $id,
                'rank' => $i
            ]);
        }
    }
}
