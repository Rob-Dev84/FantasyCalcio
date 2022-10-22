<?php

namespace App\Policies;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    //BUG - you should use a THE method in League policy - DON'T use this one. 
    // You don't actually use the invitation directly model in check, what's the point of it? 
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

        //TODO - Switch the check with user_id only after loop update implementation as soon user verify the account (sign-up process)
        // return $user->id === $invitation->user_id;

        // As consequence of what commented above, for now we safetly check the user email
        return $user->email === $invitation->email;
        
    }
}
