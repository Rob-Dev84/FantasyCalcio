<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invitations\AcceptInvitation;

class InvitationReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    
    public function accept(Request $request, Invitation $invitation)
    {
        
        //Before accept check policy
        $this->authorize('userOwnedInvitation', $invitation);

        $accepInvitation = Invitation::where('user_id', Auth::user()->id)
                                    ->where('id', $invitation->id)
                                    ->first()
                                    ->update([
            'confirmed' => true,
            ]);

        //Using relationship on user model

        // $test = $request->user()->recievedInvitation()->where('id', $invitation->id)->update([
        //     'confirmed' => true,
        // ]);

        $league_id_selected = UserSetting::where('user_id', Auth::user()->id)->first();

        //if user doesn't have any league selected, CREATE row userSetting table
        if (!$league_id_selected) {

            $request->user()->first()->userSetting()->create([
                'user_id' => Auth::user()->id,
                'league_id' => $invitation->league_id,
            ]);
        }

        //if user already have a league selected, UPDATE ------ ask if they want to keep the current league or not.. (future development) 
        // if ($league_id_selected) {//update

        //     UserSetting::first()->where('user_id', Auth::user()->id)->update([
        //         'league_id' => $invitation->league_id,
        //     ]);

        // }

        //Send email to the League Admin

        

        if ($accepInvitation) {

            //find user league admin table
            $leagueAdmin = League::where('id', $invitation->league_id)->first();
            $userAdmin = User::where('id', $leagueAdmin->user_id)->first();

            Mail::to($userAdmin->email)->send(new AcceptInvitation($leagueAdmin, $userAdmin));

        }

        return back();
    }

    public function decline(Request $request, Invitation $invitation)
    {

        //Before reject check policy
        $this->authorize('userOwnedInvitation', $invitation);

        Invitation::where('user_id', Auth::user()->id)
                                ->where('id', $invitation->id)
                                ->first()
                                ->update([
            'confirmed' => false,
            ]);

        return back();
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
