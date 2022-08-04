<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'league_id',
     ];

    public function league()
    {
    return $this->belongsTo(League::class);
    }

    public function team()
    {
    return $this->hasOneThrough(Team::class, League::class);
    }

}
