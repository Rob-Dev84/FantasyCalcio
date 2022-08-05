<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Team $team)
    {   
        //check if user id on user table, matchs the user_id in the team table (if user owns the team)
        return $user->id === $team->user_id;
    }

    // public function softDelete(User $user, Team $team)
    // {   
    
    //     return $user->id === $team->user_id;
    // }

    // public function forceDelete(User $user, Team $team)
    // {   
    
    //     return $user->id === $team->user_id;
    // }

    public function delete(User $user, Team $team)
    {   
        return $user->id === $team->user_id;
    }
}
