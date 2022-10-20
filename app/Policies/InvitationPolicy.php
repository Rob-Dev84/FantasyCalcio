<?php

namespace App\Policies;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    //FIXME - you should use a this method in League policy
    public function userLeagueAdmin(User $user, Invitation $invitation)
    {   

        //check if user id on user table, matchs the user_id in the leagues table (if user owns the league)
        $league = League::where('id', $invitation->league_id)->first();
        
        return $user->id === $league->user_id;
        
    }

    // public function userLeagueAdminInvite(User $user)
    // {       
    //     $league = League::where('id', auth()->user()->userSetting->league_id)->first();
         
    //     return $user->id === $league->user_id;
    // }

    public function userOwnedInvitation(User $user, Invitation $invitation)
    {   

        //check if user id on user table, matchs the user_id in the invitations table
        // $userInvitation = Invitation::where('user_id', $user->id)
        //                             ->first();
        
        // return $userInvitation->id === $invitation->id;

        return $user->id === $invitation->user_id;
        
    }
}
