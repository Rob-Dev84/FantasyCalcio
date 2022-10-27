<?php

namespace App\Http\Controllers\Invitation;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invitations\InviteSignedUser;
use App\Mail\Invitations\InviteUnsignedUser;
use App\Http\Requests\Invitation\StoreInvitationRequest;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $receivedInvitations = Invitation::where('email', auth()->user()->email)->with('league')->get();
        // $league = League::where('id', auth()->user()->userSetting->league_id)->first();
        $sentInvitations = Invitation::where('league_id', auth()->user()->userSetting->league_id)->get();

        return view('invitations.index', compact('receivedInvitations', 
                                                // 'league',
                                                'sentInvitations',
                                                ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invitations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvitationRequest $request, League $league)
    {
        //Check if user is league admin
        $this->authorize('userLeagueAdmin', $league);


    // FIXME - we can create a service provider and place the folling code into the register function.
    // Because we have to send an email, we can use the boot() function

        //Check if user is registered or not (we send different email)
        $user = User::where('email', $request->email)->first();
        
        Invitation::create([
            //for now it doesn't matter if they have confirmed their account
            'user_id' => ($user) ? $user->id : NULL,
            'league_id' => $league->id,
            'email' => $request->email,
        ]);

        //Send email invitation to user who is not registered yet
        if (!$user) {
            Mail::to($request->email)->send(new InviteUnsignedUser());
        }

        //Send email invitation to registered user
        if ($user) {
            Mail::to($request->email)->send(new InviteSignedUser($user));
        }
        
        return redirect('invitations');
    }

    
   
    public function softDelete(Invitation $invitation)
    {

        $this->authorize('userLeagueAdmin', $invitation);

        //SoftDelete
        $invitation->delete();

        //Check if user deleted has league_id selected
        $userSettingId = UserSetting::where('user_id', $invitation->user_id)
                                ->where('league_id', $invitation->league_id)
                                ->first();

        //unselect league from user deleted
        if ($userSettingId) {

            UserSetting::first()
                        ->where('user_id', $invitation->user_id)
                        ->update([
                'league_id' => NULL,
            ]);
        }

        return back();
    }
    
}
