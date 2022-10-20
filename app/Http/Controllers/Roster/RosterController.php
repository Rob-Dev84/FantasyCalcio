<?php

namespace App\Http\Controllers\Roster;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Market\Market;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(League $league)
    {

        // dd($league->rosters);

        // $teams = Team::where('league_id', $league->id)->get();

        $players = DB::table('markets')
                    ->leftJoin('teams', 'markets.team_id', '=', 'teams.id')
                    ->leftJoin('players', 'markets.player_id', '=', 'players.id')
                    ->where('teams.league_id', $league->id)
                    ->select('players.*', 'teams.*', 'markets.*')
                    ->orderBy('players.id')
                    ->get();

        //FIXME - play around this relationship. I woul like to get rid of the ugly query above
        // $players = auth()->user()->markets()->with(['player'])->get();
        
        //Alternative code (problem here is the loop, thah stops running after first iteration)
        
        // foreach ($teams as $team) {

        //         $players = Market::where('team_id', $team->id)
        //         ->with(['player'])
        //         ->get();

           
        // }

        // $order = ['GK', 'D', 'M', 'ST'];
        // $groupPlayers = $players->sortBy($players, ['GK', 'D', 'M', 'ST']);

        return view('rosters.index', [
                'league' => $league,
                // 'teams' => $teams,
                'players' => $players,
                // 'order' => $order,
            ]);

           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
