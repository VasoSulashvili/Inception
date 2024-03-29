<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rank>
 */
class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groupId = Group::where('name', '=', \App\Enums\GroupType::OTHER->value)
            ->first()
            ?->id;
        if(!$groupId) {
            $groupId = Group::create(['name' => \App\Enums\GroupType::OTHER->value])
                ->first()
                ->id;
        }
        return [
            'group_id' => Group::factory(),
            'rank' => fake()->randomDigit(),
            'name' => fake()->word()
        ];
    }
}
