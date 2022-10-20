<?php

namespace App\Http\Controllers\Lineup;

use App\Models\Team;
use App\Models\User;
use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Lineup\Lineup;
use App\Models\Lineup\Module;
use App\Models\Market\Player;
use App\Models\Lineup\Fixture;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Lineup\ModuleType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lineup\UpdateFixtureRequest;

class LineupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UpdateFixtureRequest $request, League $league, Fixture $fixture)
    // public function index(Request $request, League $league, Fixture $fixture)

    {// FIXME - The Form request has the validation commented out, beacuse by defalt
     // Since user navigate here, it won't request anything and I get the error. 
     // So I had to leave for now the validation on controller

        //display all league lineups. By default get most recent fixture
    
        $this->authorize('selectedLeague', $league);
       

        // The following statement gives different fixure value depending:
        // if user access the lineups by navigation bar and the fixture value is the 'current' (latest) by default  
        // else user changes the fixture from selection in lineups view page


        // FIXME - Don't use fixture, but fixture_id. 
        //  Because it's the first season, fixture and fixture_id are the same.
        // But as soon as you add another league or go for the next season, clearly they won't match anymore
            
        if ($request->fixture) {

            // Check if fixture exists per user team
            $this->validate($request, [
                'fixture' => ['required', 
                            Rule::exists('lineups', 'fixture_id')->where('team_id', auth()->user()->team->id),    
                'integer'],
            ]);
            
            $fixture = $request->fixture;

        } else {

            $fixture = Fixture::where('start', '<=', Carbon::now())
                            ->where('end', '>=', Carbon::now())
                            ->orWhere('end', '>=', Carbon::now())//case when current date is into matches interval
                            ->where('league_type_id', 1)
                            ->select('fixture')
                            ->first();

            // We want to pass only the fixture value, matching the true if statement above 
            $fixture = $fixture->fixture;
        }

        // FIXME - Better to give list of fixtures based on date where the league is started and the current date
        // We also can remove the statement in the index file where we find the fixture + 1
        $fixtures = DB::table('lineups')
                            ->leftJoin('fixtures', 'lineups.fixture_id', '=', 'fixtures.id')
                            ->leftJoin('teams', 'lineups.team_id', '=', 'teams.id')
                            ->where('teams.league_id', $league->id)
                            ->select('fixtures.fixture')
                            ->distinct()
                            ->orderByRaw('fixtures.fixture ASC')
                            ->get();

        // Tried eager loading player and league, but I got all the lineups per fixture, ignoring the league. I went for following query builder 
        $players = DB::table('lineups')
                        ->leftJoin('teams', 'lineups.team_id', '=', 'teams.id')
                        ->leftJoin('players', 'lineups.player_id', '=', 'players.id')
                        ->where('teams.league_id', $league->id)
                        ->where('lineups.fixture_id', $fixture)
                        // ->select('players.*', 'teams.*', 'lineups.*')
                        ->select('players.id', 'players.surname', 'players.role', 'players.team', 
                                'teams.name', 'teams.league_id', 
                                'lineups.team_id', 'lineups.player_status')
                        ->orderBy('players.id')
                        ->get();
        
        return view('lineups.index', compact('league', 
                                            'players',
                                            'fixtures',
                                            'fixture',
        ));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, League $league, Team $team)
    {
        // This function is used to deploy players each team and for the current fixture

        //Autorize only for the user/team league
        $this->authorize('checkTeam', $team);
        $this->authorize('selectedLeague', $league);

        //get players that team owns
        $players = auth()->user()->team->markets()->with(['player'])->get();

        //get all modules available (seeds)
        $modules = ModuleType::get();

        //Select current fixture (matchday). note you must have 'start', 'end' datestamps filled
        $fixture = Fixture::where('start', '<=', Carbon::now())
                            ->where('end', '>=', Carbon::now())
                            ->orWhere('end', '>=', Carbon::now())//case when current date is into matches interval
                            ->where('league_type_id', 1)
                            ->first();

        // if null it means time for lineup is expired (there is an if statement on create.blade file)
        $expiredFixure = Fixture::where('start', '<=', Carbon::now())
                                ->where('end', '>=', Carbon::now())
                                ->where('league_type_id', 1)
                                ->first();
        
        // if ($fixture) {
            
            //trying to use eloquent 
            $lineup_players = auth()->user()->team->lineups()->where('fixture_id', $fixture->id)
                                                            ->with(['player:id,role'])//look at the relationship in Lineup Model
                                                            ->get();

            $groupPlayers = $lineup_players->groupBy('player.role');

            //FIXME - That's really ugly

            if ($groupPlayers->count()) {
                $countPitchGoalkeepers = $groupPlayers['GK']->where('player_status', '1')->count();
                $countBenchGoalkeepers = $groupPlayers['GK']->where('player_status', '0')->count();
                $countPitchDefenders = $groupPlayers['D']->where('player_status', '1')->count();
                $countBenchDefenders = $groupPlayers['D']->where('player_status', '0')->count();
                $countPitchMidfields = $groupPlayers['M']->where('player_status', '1')->count();
                $countBenchMidfields = $groupPlayers['M']->where('player_status', '0')->count();
                $countPitchStrickers = $groupPlayers['ST']->where('player_status', '1')->count();
                $countBenchStrickers = $groupPlayers['ST']->where('player_status', '0')->count();
            } else {
                $countPitchGoalkeepers = 0;
                $countBenchGoalkeepers = 0;
                $countPitchDefenders = 0;
                $countBenchDefenders = 0;
                $countPitchMidfields = 0;
                $countBenchMidfields = 0;
                $countPitchStrickers = 0;
                $countBenchStrickers = 0;
            }


            //Get module selected and check the numbers of Defenders/Midfields/Strikes available 
            $module = Module::where('team_id', $team->id)->with('moduleType')->first();

            //Here is the selected team model 
            $module = $module->moduleType->name;

            //Get an array with three integer that we are going to use fot the max players per role
            $maxNumberPlayerModule = explode("-", $module);

            //Eg. 5-3-2, will be 531
            $numberModuleDefenters = $maxNumberPlayerModule[0];
            $numberModuleMidfields = $maxNumberPlayerModule[1];
            $numberModuleStrikers = $maxNumberPlayerModule[2];

            //TODO - Logic to order player. 
            // If 5-3-2, Defenders have 5 orders: from 1 to 5
            // Midfiels have 3 orders: from 1 to 3

            return view('lineups.create', compact('league', 
                                                'team',
                                                'players',
                                                'modules',
                                                'fixture',
                                                'lineup_players',
                                                'countPitchGoalkeepers',
                                                'countBenchGoalkeepers',
                                                'countPitchDefenders',
                                                'countBenchDefenders',
                                                'countPitchMidfields',
                                                'countBenchMidfields',
                                                'countPitchStrickers',
                                                'countBenchStrickers',
                                                'numberModuleDefenters',
                                                'numberModuleMidfields',
                                                'numberModuleStrikers',
                                                'expiredFixure',
                                            ));
            
        // } else {

        //     return view('lineups.create', compact('league', 
        //                                         'team',
        //                                         'players',
        //                                         'modules',
        //                                         'fixture',
        //                                     ));
        // }
        

        

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pitch(Request $request, League $league, Team $team, Fixture $fixture, Player $player)
    {

        //TODO - Almost the same policy from MarketController. To refactor here

        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);//abort if user change league
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);//abort if user change team
        abort_if(!auth()->user()->team->markets->contains('player_id', $player->id), code:403);//abort if user tries to deploy player which doesn't own 
        //TODO - Check current date is between strat / end timestamp of current fixture 


        // if team hasn't deploy players for the current fixture, loop all the players from market and insert to the lineup table
        if (!$request->user()->team->lineups->contains('fixture_id', $fixture->id)) {//loop players here and create()

            //get all team players from market
            $team_players = auth()->user()->team->markets()->get();

            foreach ($team_players as $team_player) {
                auth()->user()->team->lineups()->create(
                    [
                        'fixture_id' => $fixture->id,
                        // 'team_id' => $request->user()->team->id,
                        'player_id' => $team_player->player_id,
                    ]);
            }
        }

        // Check if team hasn't ritched the maximum number per role yet (pitch only)
        $lineup_players = auth()->user()->team->lineups()->where('fixture_id', $fixture->id)
                                                        ->with(['player:id,role'])//Eage Loading to get role player
                                                        // ->groupBy('player.role')
                                                        ->get();
                    


        //here is the problem: We can eaither group players per rule and split the query in 8 statement (crazy). But we avoid the foreach

        //Or we loop 
        //here we get all players per role
        $groupPlayers = $lineup_players->groupBy('player.role');

        $countPitchGoalkeepers = $groupPlayers['GK']->where('player_status', '1')->count();

        // $countBenchGoalkeepers = $groupPlayers['GK']->where('player_status', 0)->count();
        $countPitchDefenders = $groupPlayers['D']->where('player_status', '1')->count();
        // $countBenchDefenders = $groupPlayers['D']->where('player_status', 0)->count();
        $countPitchMidfield = $groupPlayers['M']->where('player_status', '1')->count();
        // $countBenchMidfield = $groupPlayers['M']->where('player_status', 0)->count();
        $countPitchStrickers = $groupPlayers['ST']->where('player_status', '1')->count();
        // $countBenchStrickers = $groupPlayers['ST']->where('player_status', 0)->count();


        //Get module selected and check the numbers of Defenders/Midfields/Strikes available 
        $module = Module::where('team_id', $team->id)->with('moduleType')->first();
        
        //Here is the selected team model 
        $module = $module->moduleType->name;

        //Get an array with three integer that we are going to use fot the max players per role
        $maxNumberPlayerModule = explode("-", $module);

        //Eg. 5-3-2, will be 531

        $numberModuleDefenters = $maxNumberPlayerModule[0];
        $numberModuleMidfields = $maxNumberPlayerModule[1];
        $numberModuleStrikers = $maxNumberPlayerModule[2];
        
        if (isset($groupPlayers['GK']) && $player->role === 'GK' && $countPitchGoalkeepers > 0) {
            die("You already deployed a Goalkeep on Pitch");
        }

        if (isset($groupPlayers['D']) && $player->role === 'D' && $countPitchDefenders > $numberModuleDefenters - 1) {
            die("You already deployed all the defenders on Pitch");
        }

        if (isset($groupPlayers['M']) && $player->role === 'M' && $countPitchMidfield > $numberModuleMidfields - 1) {
            die("You already deployed all the midfields on Pitch");
        }

        if (isset($groupPlayers['ST']) && $player->role === 'ST' && $countPitchStrickers > $numberModuleStrikers - 1) {
            die("You already deployed all the strikers on Pitch");
        }

        
        //Change the player status to TRUE (deploy player to pitch)
        $request->user()->team->lineups()->where('player_id', $player->id)
                                        ->where('fixture_id', $fixture->id)->update(
            [
                'player_status' => true,
            ]
        );

        // TODO - Logic to order player. 
        // For bench is always from 1 to 3 for all players

        return back();
    }

    public function bench(Request $request, League $league, Team $team, Fixture $fixture, Player $player)
    {

        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);//abort if user change league
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);//abort if user change team
        abort_if(!auth()->user()->team->markets->contains('player_id', $player->id), code:403);//abort if user tries to deploy player which doesn't own 


        // if team hasn't deploy players for the current fixture, loop all the players from market and insert to the lineup table
        if (!$request->user()->team->lineups->contains('fixture_id', $fixture->id)) {//loop players here and create()

            //get all team players from market
            $team_players = auth()->user()->team->markets()->get();

            foreach ($team_players as $team_player) {
                auth()->user()->team->lineups()->create(
                    [
                        'fixture_id' => $fixture->id,
                        // 'team_id' => $request->user()->team->id,
                        'player_id' => $team_player->player_id,
                    ]);
            }
        }


        // Check if team hasn't ritched the maximum number per role yet (pitch only)
        $lineup_players = auth()->user()->team->lineups()->where('fixture_id', $fixture->id)
                                                    ->with(['player:id,role'])//Eage Loading to get role player
                                                    ->get();



        //here is the problem: We can eaither group players per rule and split the query in 4 statement (crazy). But we avoid the foreach
        //Or we loop (foreach)
        //here we get all players per role
        $groupPlayers = $lineup_players->groupBy('player.role');
        
        $countBenchGoalkeepers = $groupPlayers['GK']->where('player_status', '0')->count();
        $countBenchDefenders = $groupPlayers['D']->where('player_status', '0')->count();
        $countBenchMidfield = $groupPlayers['M']->where('player_status', '0')->count();
        $countBenchStrickers = $groupPlayers['ST']->where('player_status', '0')->count();


        if (isset($groupPlayers['GK']) && $player->role === 'GK' && $countBenchGoalkeepers > 0) {
        die("You already deployed a Goalkeep on Bench");
        }

        if (isset($groupPlayers['D']) && $player->role === 'D' && $countBenchDefenders > 2) {
        die("You already deployed all the defenders on Bench");
        }

        if (isset($groupPlayers['M']) && $player->role === 'M' && $countBenchMidfield > 2) {
        die("You already deployed all the midfields on Bench");
        }

        if (isset($groupPlayers['ST']) && $player->role === 'ST' && $countBenchStrickers > 2) {
        die("You already deployed all the strikers on Bench");
        }





        //Change the player status to FALSE (bench)
        $request->user()->team->lineups()->where('player_id', $player->id)
                                        ->where('fixture_id', $fixture->id)->update(
            [
                'player_status' => false,
            ]
        );

        return back();
    }

    public function undo(Request $request, League $league, Team $team, Fixture $fixture, Player $player)
    {
        
        abort_if(auth()->user()->userSetting->league_id !== $league->id, code: 403);//abort if user change league
        abort_if(auth()->user()->userSetting->user_id !== $team->user_id, code: 403);//abort if user change team
        abort_if(!auth()->user()->team->markets->contains('player_id', $player->id), code:403);//abort if user tries to deploy player which doesn't own 

        //Change the player status to NULL
        $request->user()->team->lineups()->where('player_id', $player->id)
                                        ->where('fixture_id', $fixture->id)->update(
            [
                'player_status' => null,
            ]
        );

        return back();
    }

    // TODO - Add here just for the purpose of changing the player order (you can split it for pitch and bench) 
    // public function orderPlayer(Request $request)
    // {
        
    // }



    
}
