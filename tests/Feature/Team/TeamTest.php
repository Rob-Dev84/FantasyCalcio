<?php

namespace Tests\Feature\Team;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use App\Models\League;
use App\Models\League\ScoreType;
use App\Models\League\LeagueType;
use App\Models\League\MarketType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_disply_user_team_page()
    {
        // //Get the helper error hendler (don't use if you have some validation to test)
        // $this->withoutExceptionHandling();

        // $leagueType = LeagueType::factory()->create();
        // $marketType = MarketType::factory()->create();
        // $scoreType = ScoreType::factory()->create();
        
        // // create user (UserFactory.php file)
        // $user = User::factory()->create();

        // //USer need to be authanticate
        // $this->actingAs($user);

        // $league = League::factory()->create();

        // // Assert status 200
        // $this
        //     // ->get('/')
        //     ->get(route('dashboard'))
        //     ->assertOK();

        // // $response = $this->get(route('leagues'));

        // // $response->assertStatus(200);
    }

    // public function test_should_disply_team_form_page()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $league = League::factory()->create();
    //     $this
    //         ->get(route('team.create'))
    //         ->assertOK();

    // }
}
