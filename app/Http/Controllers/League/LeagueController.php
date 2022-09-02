<?php

namespace App\Http\Controllers\League;

use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{


    //This method won't allow user with session to do anythig in here
    //But using exept() or only(), we can specify it better
    public function __construct()
    {
        //So I want to apply the session restriction only to the store() and destroy() methods
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        //Show all the user Leagues avaible, with the get() method, per user_id 
        $leagues = League::get()->where('user_id', Auth::user()->id);

        //Show all the user Leagues in trash (probably you can use the fist one, retreive all leagues, included the trashed, and in blade file add condition)
        $leagues_deleted = League::onlyTrashed()->get()->where('user_id', Auth::user()->id);

        //Get user league_id selected
        $leagueSelected = UserSetting::where('user_id', Auth::user()->id)->first();

        $receivedInvitations = NULL;
        $leagues_guest = NULL;

        //Get all user Invitation received (use relationship un user model, to get the invitation table and the league name)
        $receivedInvitations = Invitation::get()->where('user_id', Auth::user()->id);

        if ($receivedInvitations) {
            //Get league name (better a join between invitation/league table)
            foreach ($receivedInvitations as $receivedInvitation) {

                $leagues_guest = League::withTrashed()->find($receivedInvitation->league_id);

                // dd($leagues_guest);

            }
        }

        
        

        
        //Here we put the league into an array. You need to iterate in you view file (leagues/index.blade.php)
        return view('leagues.index', [
            'leagues' => $leagues,
            'leagues_deleted' => $leagues_deleted,
            'leagueSelected' => $leagueSelected,
            'receivedInvitations' => $receivedInvitations,
            'leagues_guest' => $leagues_guest,
        ]);

 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leagues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, League $league)
    {
        $this->validate($request, [
            'name' => 'required|unique:leagues|min:3|max:25',
            'league_type' => 'required|integer|between:1,1',
            'market_type' => 'required|integer|between:1,1',
            'score_type' => 'required|integer|between:1,1',
            'budget' => 'required|integer|between:350,500',
        ]);

        //instead of adding user_id manually: 'usder_id' => auth->id(), we can use this hand notation: $request->user()->leagues()->create([])
        //or this notation: auth()->user()->posts()->create();
        $league = $request->user()->leagues()->create([
            'name' => $request->name,
            'league_type_id' => $request->league_type,
            'market_type_id' => $request->market_type,
            'score_type_id' => $request->score_type,
            'budget' => $request->budget,
        ]);

        

        //Select league created in user_setting table user_id and league_id. Create/Update depending if user already or not have a league

        $league_id = $league->id;

        //select league_id from user:setting table
        // $league_id_selected = UserSetting::where('user_id', Auth::user()->id)->first(['league_id'])->league_id;

        $league_id_selected = UserSetting::where('user_id', Auth::user()->id)->first();

        if (!$league_id_selected) {//Create

            $selectLeague = $league->user()->first()->userSetting()->create([
                'user_id' => $request->user()->id,
                'league_id' => $league->id,
            ]);
        } 
        if ($league_id_selected) {//update

            UserSetting::first()->where('user_id', Auth::user()->id)->update([
                'league_id' => $league_id,
            ]);

        }
        

        //Before adding new row, check if user already has a league created

        //$select_league = UserSetting::where('user_id', $user_id)->first();

        //if yes, update it first

        //--------------//

        //USE THIS ONE BELOW

        //Or we can use updateOrCreate()
        // UserSetting::updateOrCreate(['user_id' => $user_id], ['league_id' => $league_id]);

        // return back();
        return redirect('leagues');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(league $league)
    {
        // return view('leagues.show', [
        //     'league' => $league
        // ]);
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
    public function softDelete(Request $request, League $league)
    {

        //Check if user owns the league
        $this->authorize('userLeagueAdmin', $league);

        //Delete using unser and leagues methods and check the league id to delete. It won't work if user try to change the id value
        $request->user()->leagues()->where('id', $league->id)->delete();

        //If user deleted the selected league, update the league_id to NULL
        $league->user()->first()->userSetting()->update([
            'league_id' => null,
        ]);

        //Loop the userSettings table
        $leaguesSelected = UserSetting::where('league_id', $league->id)->get();

        if ($leaguesSelected->count()) {
            //If user has league selected, update to null (we don't want user guess to access to a deleted league)
            foreach ($leaguesSelected as $leagueSelected) {
                $league->userSetting->update([
                    'league_id' => null,
                ]);
            }
        }

        return back();
    }


    
    // public function restore(Request $request, $id)
    // {
    //     //here we use the id to restore the league

    //     //    $league = League::onlyTrashed()->findOrFail($id);
    //     //    $league->restore();

    //     //Check if user owns the league
    //     $this->authorize('userLeagueAdmin', $league);

    //    $request->user()->leagues()->where('id', $id)->restore();
    //    return back();
    // }

    

    // public function forceDelete(Request $request, $id)
    // {
    //     // dd($league_deleted);
    //     $request->user()->leagues()->where('id', $id)->forceDelete();
    //     return back();
    // }
}
