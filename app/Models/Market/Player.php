<?php

namespace App\Models\Market;

use App\Models\Lineup\Lineup;
use App\Models\Market\Market;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'name',
        'surname', 
        'role',
        'team',
        'initial_value',
        'current_value',
        'league_type_id',
        'active',
    ];

    public $timestamps = false;

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    // public function market()
    // {
    //     return $this->belongsToMany(Market::class, 'player_id');
    // }


    // public function lineups()
    // {
    //     return 
    //     $this->belongsTo(Lineup::class);
    // }


}
