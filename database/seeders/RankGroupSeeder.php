<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => \App\Enums\Rank\RankGroup::WINNER->value
        ]);

        Group::create([
            'name' => \App\Enums\Rank\RankGroup::RUNNER_UP->value
        ]);

        Group::create([
            'name' => \App\Enums\Rank\RankGroup::OTHER->value
        ]);
    }
}
