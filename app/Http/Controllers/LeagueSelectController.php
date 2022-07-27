<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\UserSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueSelectController extends Controller
{

    
    //Update the league_id value when user switch league
    public function update(Request $request, League $league)
    {

        //Check if the league is selected by the user is already selected (you don't need this, because you do an update anyway.)
        //Who cares if user update the query for the same league_id? 
        //This method is essencial when user can create ONLY one row and you want to make sure that user won't create another one.
        //You might use this when a team wants to buy a player. Check if team already has this player. (for free market)

        // if ($league->selectedBy($request->user())) {
        //     return response(null, 409);
        // }


        $selectLeague = $league->user()->first()->userSetting()->update([
            // 'user_id' => $request->user()->id,
            'league_id' => $league->id,
        ]);
   
        return back();
    }
}
