<?php

namespace App\Http\Controllers\League;

use App\Models\League;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeagueTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = auth()->user()->leagues()->onlyTrashed()->get();
        
        return view('leagues.trash', [
            'leagues' => $leagues,
        ]);
    }

    public function restore(League $league)
    {
        //Check if user owns the league
        $this->authorize('userLeagueAdmin', $league);

        $league->restore();

        if (auth()->user()->leagues()->onlyTrashed()->count()) {
            return back();
        } else {
            return redirect('leagues');
        }
       
    }

    public function forceDelete(League $league)
    {
        //Check if user owns the league
        $this->authorize('userLeagueAdmin', $league);

        $league->forceDelete();
        
        if (auth()->user()->leagues()->onlyTrashed()->count()) {
            return back();
        } else {
            return redirect('leagues');
        }
    }

}
