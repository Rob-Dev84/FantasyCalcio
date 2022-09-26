<?php

namespace App\Policies;

use App\Models\Team;
// use App\Models\League;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class MarketPolicy
{
    use HandlesAuthorization;

    public function buyPlayer(User $user, Team $team)
    {   

        // $league = League::where('id', auth()->user()->userSetting->user_id)->first();
        // $team = Team::where('league_id', auth()->user()->userSetting->user_id)
        //             ->where('user_id', auth()->user()->id)->first();
        //check if user has in the proper league and owns the team
        // if (auth()->user()->userSetting->league_id === $league->id) {

            return $user->id === $team->user_id;
            // return Response::deny('Munnezz');

        // }
        
    }

    // public function sell(User $user, League $league, Team $team)
    // {   
    //     //check if user id on user table, matchs the user_id in the team table (if user owns the team)
    //     return $user->id === $team->user_id;
    // }
}
