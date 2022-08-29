<?php

namespace App\Policies;

use App\Models\User;
use App\Models\League;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaguePolicy
{
    use HandlesAuthorization;

    public function softDelete(User $user, League $league)
    {   
        //check if user id on user table, matchs the user_id in the league table (if user owns the league)
        return $user->id === $league->user_id;
    }

    public function forceDelete(User $user, League $league)
    {   
        //check if user id on user table, matchs the user_id in the league table (if user owns the league)
        return $user->id === $league->user_id;
    }

    //Invitation

    
}
