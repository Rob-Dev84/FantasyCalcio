<?php

namespace App\Models;

use App\Models\League;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'league_id',
        'email',
        'confirmed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function userSetting()
    {
        return $this->belongsTo(UserSetting::class, 'league_id');
    }


}
