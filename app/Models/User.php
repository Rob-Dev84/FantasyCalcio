<?php

namespace App\Models;

// use App\Models\User;
// use App\Models\League;
// use App\Models\UserSetting;
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


    //relationship to retrieve the user setting (for now the seleceted league)
    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }

    //Get the team Through the userSetting model
    public function team()
    {
        return $this->hasOneThrough(Team::class, UserSetting::class, 'league_id', 'league_id');
    }
    
    
}
