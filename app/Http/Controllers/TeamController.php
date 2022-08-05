<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get user league_id selected
        $league = UserSetting::where('user_id', Auth::user()->id)->first();

        //Get user team per league selected
        $team = Team::where('user_id', Auth::user()->id)->where('league_id', $league->league_id)->first();

        return view('team.index', [
            'team' => $team 
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(League $league)
    {
        return view('team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->team()->user_id);
        $this->validate($request, [
            'name' => ['required', //Unique team name per league 
                        Rule::unique('teams')->where('user_id', Auth::user()->id, 'league_id', Auth::user()->userSetting->league_id),    
                        'min:3|max:25'],
            'stadium' => 'required|min:3|max:25'
        ]);

        //Get user league_id selected
        $league = UserSetting::where('user_id', Auth::user()->id)->first();

        //Get user team per league selected
        $team = team::where('user_id', Auth::user()->id)->where('league_id', $league->league_id)->first();

        //Create new team if user hasn't created one yet
        if ($team) {
            return back();
            die();
        }

        $request->user()->team()->create([
            'user_id' => Auth::user()->id,
            'league_id' => $league->league_id,
            'name' => $request->name,
            'stadium' => $request->stadium,
        ]);

        return redirect('team');

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
    public function edit(Team $team)
    {
        if (Auth::user()->id === $team->user_id) {
            return view('team.edit', [
                'team' => $team
            ]);
        } else {
            return back();
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        // Note: Better to use ignore($team), then the $team->id, to prevent SQL injection
        $this->validate($request, [
            'name' => ['required', //Ignore unique teame when user update name and Keep Unique team name per league 
                        Rule::unique('teams')->ignore($team)
                                             ->where('user_id', Auth::user()->id, 'league_id', Auth::user()->userSetting->league_id),    
                        'min:3|max:25'],
            'stadium' => 'required|min:3|max:25'
        ]);

        $request->user()->team()->first()->update([
            'name' => $request->name,
            'stadium' => $request->stadium,
        ]);

        return redirect('team');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);//delete is the method name we defined in TeamPolicy file. And we want to pass the $team object as well
        $team->delete();

        return redirect('team');
    }
}
