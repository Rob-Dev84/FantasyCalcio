<?php

namespace App\Models\Market;

use App\Models\Team;
use App\Models\UserSetting;
use App\Models\Market\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'player_id',
        'expense',
    ];


    // public function players()
    // {
    //     return $this->belongs(Player::class);
    // }
    
    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    // public function team()
    // {
    //     return $this->hasOneThrough(Team::class, UserSetting::class, 'league_id', 'league_id');
    // }


}
