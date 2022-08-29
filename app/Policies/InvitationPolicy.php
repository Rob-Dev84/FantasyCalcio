<?php

namespace App\Policies;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    public function userLeagueAdmin(User $user, Invitation $invitation)
    {   

        //check if user id on user table, matchs the user_id in the leagues table (if user owns the league)
        $league = League::where('id', $invitation->league_id)->first();
        
        return $user->id === $league->user_id;
        
    }

    public function userOwnedInvitation(User $user, Invitation $invitation)
    {   

        //check if user id on user table, matchs the user_id in the invitations table
        $userInvitation = Invitation::where('user_id', $user->id)
                                    ->first();
        
        return $userInvitation->id === $invitation->id;
        
    }
}
