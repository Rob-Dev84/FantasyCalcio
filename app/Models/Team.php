<?php

namespace App\Models;

// use App\Models\User;
// use App\Models\League;
use App\Models\Team;
use App\Models\Lineup\Lineup;
use App\Models\Lineup\Module;
use App\Models\Market\Market;
use App\Models\Market\Player;
use App\Models\Lineup\Fixture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'league_id',
        //TODO - Add user_seting_id to the team table and drop user_id and league_id
        // 'user_setting_id',
        'name',
        'stadium',
        'budget',
    ];

    public function user()
    {
        return $this->belongsTo(UserSetting::class);
    }
    

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    // public function userSetting() {
    //     return $this->hasOne(UserSetting::class);
    // }

    public function markets()
    {
        return $this->hasManyThrough(Market::class, Team::class, 'id', 'team_id');
    }

    public function module()
    {
        return $this->hasOne(Module::class);
    }

    public function lineups()
    {
        return $this->hasMany(Lineup::class);
    }

    // public function lineups()
    // {
    //     return $this->hasMany(Lineup::class, Player::class);
    // }

    // public function players()
    // {
    //     return $this->hasMany(Player::class);
    // }

}
