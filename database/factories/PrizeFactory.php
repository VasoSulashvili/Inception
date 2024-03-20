<?php

namespace Database\Factories;

use App\Enums\PrizeType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prize>
 */
class PrizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'type' => Arr::random([PrizeType::LOTTERY->value, PrizeType::LOTTERY->value],1)[0],
            'active' => 1
        ];
    }
}
