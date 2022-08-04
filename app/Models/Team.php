<?php

namespace App\Models;

// use App\Models\User;
// use App\Models\League;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'league_id',
        'name',
        'stadium',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function userSetting() {
        return $this->hasOne(UserSetting::class);
    }

}
