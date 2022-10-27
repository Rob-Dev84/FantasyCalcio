<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
// use App\Models\League\ScoreType;
// use App\Models\League\LeagueType;
// use App\Models\League\MarketType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class LeagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'league_type_id' => 1,
            // 'league_type_id' => LeagueType::factory()->hasLeagueType(1),
            'market_type_id' => 1,
            // 'market_type_id' => MarketType::factory(),
            'score_type_id' => 1,
            // 'score_type_id' => ScoreType::factory(),
            'budget' => 350,
        ];
    }
}
