<?php

namespace App\Policies;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaguePolicy
{
    use HandlesAuthorization;

    public function userLeagueAdmin(User $user, League $league)
    {   
        //check if user id on user table, matchs the user_id in the league table (if user owns the league)    
        return $user->id === $league->user_id;
    }

    public function selectLeague(User $user, League $league)
    {   
        //check id user is guest
        $invitation = Invitation::where('league_id', $league->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($invitation) {//user league guest
            return  $user->id === $invitation->user_id;
        } else {//user league admin
            return $user->id === $league->user_id;
        }
    
    }

    public function selectedLeague(User $user, League $league)
    {   
        //Check league id selected on userSettings table
        $selectedLeague = UserSetting::where('league_id', $league->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($selectedLeague) {//if true, policy is checked

            return $user->id === $selectedLeague->user_id;

        } else {//If false, don't check and retum false anyway
            
            return false;
        }
    
    }

    
}
