<?php

namespace Database\Factories;

use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "username" => fake()->userName(),
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "gender" => 'male',
            "lang" => "en",
            "email" => fake()->email(),
            "rank_id" => Rank::factory(),
            "password" => bcrypt('password'),
            "balance" => "0.0000",
            "is_blocked" => "0",
        ];
    }
}
