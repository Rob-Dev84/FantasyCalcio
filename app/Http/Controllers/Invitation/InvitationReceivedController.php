<?php

namespace App\Http\Controllers\Invitation;

use App\Models\User;
use App\Models\League;
use App\Models\Invitation;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invitations\AcceptInvitation;
use App\Http\Controllers\Controller;

class InvitationReceivedController extends Controller
{
    
    public function accept(Request $request, Invitation $invitation)
    {

        //We need to check the emails here, because League admin can invite user who are not signed up yet
        $this->authorize('userOwnedInvitation', $invitation);
        
        if ($invitation->confirmed === NULL) {
    
            return response()->json(['error' => 'Munnezz'], status:442);
            die();
        }

        
        
        // $request->user()->receivedInvitations()->first()->update($request->only('name', 'stadium'));

        $accepInvitation = $request->user()->receivedInvitations()->where('id', $invitation->id)->update(['confirmed' => true]);

        // TODO - We cound add new row on leagues table as well. 
        // However, we need to implement a column which indicate who is the admin and not (a boolean) 

        $league_id_selected = UserSetting::where('user_id', auth()->user()->id)->first();

        //if user doesn't have any league selected, CREATE row userSetting table
        if (!$league_id_selected) {

            $request->user()->userSetting()->create([
                'user_id' => auth()->user()->id,
                'league_id' => $invitation->league_id,
            ]);
        }

        //if user already have a league selected, UPDATE ------ ask if they want to keep the current league or not.. (future development) 
        // if ($league_id_selected) {//update

        //     UserSetting::first()->where('user_id', Auth::user()->id)->update([
        //         'league_id' => $invitation->league_id,
        //     ]);

        // }

        //Send email to the League Admin about new user joint the League
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

        $declineInvitation = $request->user()->receivedInvitations()
                            ->where('id', $invitation->id)
                            ->update(['confirmed' => false]);

        // Invitation::where('user_id', auth()->user()->id)
        //                         ->where('id', $invitation->id)
        //                         ->first()
        //                         ->update([
        //     'confirmed' => false,
        //     ]);

        return back();
    }



}
