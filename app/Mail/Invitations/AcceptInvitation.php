<?php

namespace App\Mail\Invitations;

use App\Models\User;
use App\Models\League;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $leagueAdmin;

    public $userAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(League $leagueAdmin, User $userAdmin)
    {
        $this->leagueAdmin = $leagueAdmin;
        $this->userAdmin = $userAdmin;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invitations.accept')
                    ->subject('FantasyCalcio Invitation Accepted');
    }
}
