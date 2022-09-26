<?php

namespace App\Http\Controllers\Market;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Market\Player;
use App\Models\Market\Market;
use App\Http\Controllers\Controller;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(League $league, Team $team)
    {

        //TODO - move these two checks in root and you can you gates
        
        // 1. Make sure the user is in right league (userSetting)
        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);

        // 2. Make sure the user selected their own team 
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);


        //Get list of players avalible for the market
        $players = Player::where('league_type_id', '1')->paginate(25);
        
        // $players = Player::with('market')->where('league_type_id', '1')->paginate(25);

        //Get the players bought from a team
        $teamPlayers = Market::where('team_id', $team->id)->with('player')->get();

        $teamPlayersRole = $teamPlayers->groupBy('player.role');
        
        //Count number of players team bought per role
        $numerGoalkeepers = ($teamPlayersRole->has('GK')) ? $teamPlayersRole['GK']->count() : 0;
        $numerDefenders = ($teamPlayersRole->has('D')) ? $teamPlayersRole['D']->count() : 0;
        $numerMidfielders = ($teamPlayersRole->has('M')) ? $teamPlayersRole['M']->count() : 0;
        $numerStrikers = ($teamPlayersRole->has('ST')) ? $teamPlayersRole['ST']->count() : 0;

       

        return view('markets.index', [
            'league' => $league,
            'team' => $team,
            'players' => $players,
            'teamPlayers' => $teamPlayers,
            'numerGoalkeepers' => $numerGoalkeepers,
            'numerDefenders' => $numerDefenders,
            'numerMidfielders' => $numerMidfielders,
            'numerStrikers' => $numerStrikers,
        ]);
    }

    public function search(Request $request)
    {
        // dd($request);
        $player = Player::where('surname', 'like', '%'.$request->q.'%')->get();
        // $player = Player::where('surname', $request->q);
        return $player;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request, League $league, Team $team, Player $player)
    {
        
        // $this->authorize('buyPlayer', $team);

        //TODO - Tidy up these policies

        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);//abort if user change league
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);//abort if user change team
        abort_if(auth()->user()->team->markets->contains('player_id', $player->id), code:403);//abort if user buy player twice
        
        
        
        //Logic that checks team number of players allows to buy (GK = 3, D= 8, M = 8, ST = 6)

        $playersTeam = Market::where('team_id', $team->id)->with(['player'])->get();
 
        $groupPlayers = $playersTeam->groupBy('player.role');

        if (isset($groupPlayers['GK']) && $player->role === 'GK' && $groupPlayers['GK']->count() > 2) {
            die("You reached the maximum number of goalkeepers");
        }

        if (isset($groupPlayers['D']) && $player->role === 'D' && $groupPlayers['D']->count() > 7) {
            die("You reached the maximum number of defenders");
        }

        if (isset($groupPlayers['M']) && $player->role === 'M' && $groupPlayers['M']->count() > 7) {
            die("You reached the maximum number of midfields");
        }

        if (isset($groupPlayers['ST']) && $player->role === 'ST' && $groupPlayers['ST']->count() > 5) {
            die("You reached the maximum number of strickers");
        }

        //Check if Team has enough money for the player Selected
        if ($team->budget < $player->current_value) {
            die("You don't have enough money to buy the selected player");
        }

        
        //Store it in markets table
        $market = $request->user()->markets()->create([
            'team_id' => $team->id,
            'player_id' => $player->id,
        ]);

        //Subtract the player value to the team budget 
        if ($market) {
            $expense = $team->budget - $player->current_value;

            $market = $request->user()->team()->update([
                'budget' => $expense,
            ]);
        }

        return back();

    }

    public function sell(Request $request, League $league, Team $team, Player $player)
    {

        

        //TODO - policy check, only if the team bouught the player. Otherwise the user budget will increase

        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);//abort if user change league
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);//abort if user change team
        
        //If it's false user cannot sell the  (Better a popup with error message)
        abort_if(!auth()->user()->team->markets->contains('player_id', $player->id), code:403);//abort if user buy player twice

        //TODO - Max 3 goalkeepers/ 8 defenders / 8 mildfields / 6 strikers

        // if (auth()->user()->team->markets->contains('player_id')) {
        //     # code...
        // }

        //Store it in markets table
        $sellPlayer = $request->user()->markets()->where('player_id', $player->id)->delete();

        //Subtract the player value to the team budget 
        if ($sellPlayer) {
            $income = $team->budget + $player->current_value;

            $request->user()->team()->update([
                'budget' => $income,
            ]);
        }

        return back();

    }

    
}
