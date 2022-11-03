<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    //TODO - check if you actually use this one. I already have an authorization in UpdateTeamRequest.php file
    public function update(User $user, Team $team)
    {   
        return $user->id === $team->user_id;
    }

    public function checkTeam(User $user, Team $team)
    {
        return $user->id === $team->user_id;
    }

    public function delete(User $user, Team $team)
    {   
        return $user->id === $team->user_id;
    }
}
