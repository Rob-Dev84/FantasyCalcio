<?php

namespace App\Http\Controllers\Invitation;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvitationTrashController extends Controller
{
    public function __construct()
    {
        //add restrictions - only update is avaible
        $this->middleware(['auth'])->only(['restore', 'forceDelete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invitations = Invitation::onlyTrashed()
                                ->where('league_id', auth()->user()->leagueOwnedBy->userSetting->league_id)->get();
        
        return view('invitations.trash', [
            'invitations' => $invitations,
        ]);
    }


    public function restore(Invitation $invitation)
    {

        $this->authorize('userLeagueAdmin', $invitation);

        $invitation->restore();

        // alert()->success('User restored to the League')->persistent('Ok');

        if (auth()->user()->invitations()->onlyTrashed()->count()) {
            return back();
        } else {
            return redirect('invitations');
        }
        
    }

    public function forceDelete(Invitation $invitation)
    {
        //Before deleting check policy delete
        $this->authorize('userLeagueAdmin', $invitation);
    
        $invitation->forceDelete();
        return back();
    }
}
