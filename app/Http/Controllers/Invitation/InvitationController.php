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
        //TODO - Check this query. Probably you can delete it, because we ritched this query using ELOQUENT directly in the index.blade.php file
        $receivedInvitations = Invitation::where('email', auth()->user()->email)->get();

        // $sentInvitations = Invitation::get()->where('league_id', Auth::user()->userSetting->league->id);
        $sentInvitations = Invitation::get()->where('league_id', auth()->user()->userSetting->league_id);

        //In case the $invitations is NULL we call the initial condition
        $receivedInvitation = NULL;
        $league = NULL;

        foreach ($receivedInvitations as $receivedInvitation) {
            
            $league = League::find($receivedInvitation->league_id);

        }

        $leagueOwnedBy = League::where('id', auth()->user()->userSetting->league_id)->first();

        return view('invitations.index', [
            'receivedInvitations' => $receivedInvitations,
            'receivedInvitation' => $receivedInvitation,
            'sentInvitations' => $sentInvitations,
            'league' => $league, 
            'leagueOwnedBy' => $leagueOwnedBy, 
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

        // TODO - create a custom from Validation | php artisan make:request StoreInvitationRequest
        
        // 1. Rule Check Autoinvitation
        // 2. Rule Check duplicates invitation

        // TODO - Make a custom error for this case when the invitation is in the trash

        //Note: this validation works only if league admin can invite friends to join the league

        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255',
                        Rule::unique('users')->where('id', auth()->user()->userSetting->league_id),//if league admin invites themself
                        Rule::unique('invitations')->where('email', $request->email)
                                                    ->where('league_id', auth()->user()->userSetting->league_id),//if user has already bein invited
                        ],
        ]);
 
        
        $league = League::where('id', auth()->user()->userSetting->league_id)->first();
        

        //Policy here - because is create from form, I cannot use policy authorize() method
        abort_if(auth()->user()->id !== $league->user_id, code: 403);
        

        $invitation = Invitation::where('email', $request->email)
                                  ->where('league_id', $league->league_id)
                                  ->first();

        //Check if user is already registered
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
