<?php

namespace App\Http\Controllers;

// use App\Models\Team;
use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invitations\InviteSignedUser;
use App\Mail\Invitations\InviteUnsignedUser;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Get all user Invitation received
        $receivedInvitations = Invitation::get()->where('email', Auth::user()->email);

        // $sentInvitations = Invitation::get()->where('league_id', Auth::user()->userSetting->league->id);
        $sentInvitations = Invitation::get()->where('league_id', Auth::user()->userSetting->league_id);

        //In case the $invitations is NULL we call the initial condition
        $receivedInvitation = NULL;
        $league = NULL;

        foreach ($receivedInvitations as $receivedInvitation) {
            
            $league = League::find($receivedInvitation->league_id);

        }

        return view('invitations.index', [
            'receivedInvitations' => $receivedInvitations,
            'receivedInvitation' => $receivedInvitation,
            'sentInvitations' => $sentInvitations,
            'league' => $league, 
        ]);
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
    public function store(Request $request)
    {
        

        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255',
                        Rule::unique('users')->ignore($request)
                                            ->where('id', Auth::user()->id),//if league admin invites themself
                        Rule::unique('invitations')->where('email', $request->email, 'league_id', $request->league_id)//if league admin already invited user
                        ],
        ]);

        /* I alredy checked the emails on validation above. I don't need these checks below */

        // if ($request->email === Auth::user()->email) {//Autoinvitation
        //     return "You can invited yourself";
        //     die();
        // }

        // if ($invitation) {//Avoid duplicates
        //     return 'You already invited this user to your League';
        //     die();
        // }

        // $trashedInvitation = Invitation::where('email', $request->email)
        //                                 ->where('league_id', $league->league_id)
        //                                 ->withTrashed()
        //                                 ->first();

        // if ($trashedInvitation) {//Avoid duplicates
        //     return 'You already invited this user but is in your invitation trash. You can make the invitation by restoring it';
        //     die();
        // }
        
        $league = UserSetting::where('user_id', Auth::user()->id)->first();

        // $league = League::first()->with('user', 'userSetting');
        // dd($league);

        $invitation = Invitation::where('email', $request->email)
                                  ->where('league_id', $league->league_id)
                                  ->first();

        $user = User::where('email', $request->email)->first();
        
        (!$user) ? $user_id = NULL : $user_id = $user->id;


        if (!$invitation) {//create
            Invitation::create([
                //for now it doesn't matter if they have confirmed their account
                'user_id' => $user_id ,
                'league_id' => $league->id,
                'email' => $request->email,
            ]);
        } 

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
    public function update()
    {
        //
    }

    public function softDelete(Invitation $invitation)
    {
        //Before deleting check policy delete
        $this->authorize('userLeagueAdmin', $invitation);

        //SoftDelete
        $invitation->delete();

        //Check if user deleted has league_id selected
        $user_setting_id = UserSetting::where('user_id', $invitation->user_id)
                                ->where('league_id', $invitation->league_id)
                                ->first();

        //unselect league from user deleted. I don't want the user deleted see anything about the league
        if ($user_setting_id) {

            UserSetting::first()
                        ->where('user_id', $invitation->user_id)
                        ->update([
                'league_id' => NULL,
            ]);
        }

        return back();
    }


}
