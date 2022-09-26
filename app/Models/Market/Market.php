<?php

namespace App\Models\Market;

use App\Models\Market\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'player_id',
        // 'role',
    ];


    // public function players()
    // {
    //     return $this->belongs(Player::class);
    // }
    
    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

}
