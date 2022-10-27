<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\League;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'user_id' => User::inRandomOrder()->first()->id,
            // 'league_id' => League::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'league_id' => League::factory(),
            'name' => fake()->name(),
            'stadium' => fake()->words(),
            'budget' => 350,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
