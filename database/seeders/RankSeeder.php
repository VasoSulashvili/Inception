<?php

namespace Database\Seeders;

use App\Models\Rank;
use App\Models\Group;
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
                $id = Group::where('name', \App\Enums\Rank\RankGroup::WINNER->value)->first()->id;
            } elseif ($i > 3 && $i < 9) {
                $id = Group::where('name', \App\Enums\Rank\RankGroup::RUNNER_UP->value)->first()->id;
            } else {
                $id = Group::where('name', \App\Enums\Rank\RankGroup::OTHER->value)->first()->id;
            }

            Rank::factory()->create([
                'group_id' => $id,
                'rank' => $i
            ]);
        }
    }
}
