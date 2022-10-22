<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('team.index');
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
    public function store(StoreTeamRequest $request, League $league)
    {

        $request->user()->team()->create([
            'user_id' => auth()->user()->id,
            'league_id' => $league->id,
            'name' => $request->name,
            'stadium' => $request->stadium,
            'budget' => $league->budget,
        ]);

        // $request->user()->team()->create($request->only('user_id', 'league_id', 'name', 'stadium', 'budget'));

        return redirect('team');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {

        $this->authorize('checkTeam', $team);

        return view('team.edit', [
            'team' => $team
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);

        $request->user()->team()->first()->update($request->only('name', 'stadium'));

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
