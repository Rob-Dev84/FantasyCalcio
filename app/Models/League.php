<?php

namespace App\Models;

// use App\Models\User;
// use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class League extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'league_type_id',
        'market_type_id',
        'score_type_id',
        'budget' ,
    ];

    // protected $casts = [
    //     'qty' => 'integer',
    // ];

    /**
     * Get the user that owns the League
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    // public function selectedBy(User $user)
    // {
    //     return $this->userSetting->contains('user_id', $user->id);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function selectedBy(User $user)
    {
        return $this->userSetting->contains('user_id', $user->id);
    }

    //relationship to retrieve the user setting (for now the seleceted league)
    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    





}

