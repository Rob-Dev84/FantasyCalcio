<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'surname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    // public function leagueOwnedBy()
    // {
    //     return $this->hasOne(League::class);
    // }
    
    //To display invitation admin trash
    public function leagueOwnedBy()
    {
        return $this->hasOneThrough(League::class, UserSetting::class, 'user_id', 'user_id'); 
    }

    //relationship to retrieve the user setting (for now the seleceted league)
    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }

    //invitations() pull out the invitations from the User League Admin
    public function invitations() //better to call this method sentInvitation()
    {
        return $this->hasManyThrough(Invitation::class,  UserSetting::class, 'id', 'league_id');
    }

    public function recievedInvitation()//user can recieve one invitation per league
    {
        return $this->hasOneThrough(Invitation::class, UserSetting::class, 'id', 'league_id');
    }

    // public function recievedInvitations()//user can recieve one invitation per league
    // {
    //     return $this->hasOneThrough(Invitation::class, League::class, 'id', 'league_id');
    // }

    public function receivedInvitations()//this pulls out all the invitations from all leagues (on pending)
    {
        return $this->hasMany(Invitation::class);
    }

    public function leagueReceivedInvitation()//this pulls out all the invitations from all leagues (on pending)
    {
        return $this->hasOneThrough(Invitation::class, League::class, 'user_id', 'user_id');
    }

    //Get the team Through the userSetting model
    public function team()
    {
        return $this->hasOneThrough(Team::class, UserSetting::class, 'league_id', 'league_id');
    }

    
}
