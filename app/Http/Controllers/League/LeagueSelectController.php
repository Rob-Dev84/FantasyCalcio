<?php

namespace App\Http\Controllers\League;

use App\Models\League;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeagueSelectController extends Controller
{

    public function __construct()
    {
        //add restrictions - only update is avaible
        $this->middleware(['auth'])->only(['update']);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
        
        //You might use this when a team wants to buy a player. Check if team already has this player. (for free market)

        // if ($league->selectedBy($request->user())) {
        //     return response(null, 409);
        // }
        
        //Use policy method here, check: 1. if the league_id is owned by user (leagues table); 2. if the league_id is in the ivitetetions table, with same user_id
        $this->authorize('selectLeague', $league);
        

        $selectLeague = auth()->user()->userSetting()->update([
            'league_id' => $league->id,
        ]);
   
        return back();
    }
    
}
