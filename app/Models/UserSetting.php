<?php

namespace App\Models;

use App\Models\League;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'league_id',
     ];

     public function user()
    {
    return $this->belongsTo(User::class);
    }


    public function league()
    {
    return $this->belongsTo(League::class);
    }

    // public function team()
    // {
    // return $this->hasOneThrough(Team::class, League::class);
    // }

    // public function team()
    // {
    // return $this->belongsTo(Team::class);
    // }

    // public function team()
    // {
    //     return $this->hasOne(Team::class, 'league_id');
    // }

    // public function sentInvitations()
    // {
    //     return $this->hasManyThrough(Invitation::class, League::class, 'id', 'league_id')->withTrashed();
    // }

    // public function sentInvitations()
    // {
    //     return $this->hasMany(Invitation::class, 'league_id')->withTrashed();
    // }

    public function sentInvitations()// All invitations received as guest with league info
    {
        return $this->hasMany(Invitation::class, 'league_id', 'league_id')->withTrashed();
        // return 'asds';
    }

}
