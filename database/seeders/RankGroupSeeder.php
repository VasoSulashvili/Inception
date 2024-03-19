<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class RankGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => \App\Enums\GroupType::WINNER->value
        ]);

        Group::create([
            'name' => \App\Enums\GroupType::RUNNER_UP->value
        ]);

        Group::create([
            'name' => \App\Enums\GroupType::OTHER->value
        ]);
    }
}
