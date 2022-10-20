<?php

namespace App\Models\Lineup;

use App\Models\Team;
use App\Models\League;
use App\Models\UserSetting;
// use App\Models\Market\Market;
use App\Models\Market\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lineup extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'team_id',
        'player_id',
        'player_status',
        // 'league_id',
    ];

    // public function players()
    // {
    //     return $this->hasManyThrough(Player::class, Market::class, 'player_id', 'id');
    // }

    // public function player()
    // {
    //     return $this->hasOneThrough(Player::class, Market::class, 'player_id', 'id');
    // }

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    // public function players()
    // {
    //     return $this->hasMany(Player::class,'id', 'player_id');
    // }



    public function league()
    {//this is an inverted relationship
        // return $this->hasOneThrough(League::class, Team::class, 'league_id', 'id', 'team_id', 'id');
        return $this->hasOneThrough(League::class, Team::class, 'league_id', 'id', 'team_id', 'id');
    }

    public function teams()
    {
        return $this->belongsTo(League::class, 'league_id');
    }
    
}
