<?php

namespace App\Models;

// use App\Models\League;
use App\Models\Market\Market;
use App\Models\League\ScoreType;
use App\Models\League\LeagueType;
use App\Models\League\MarketType;
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

    public function leagueType()
    {
        return $this->hasOne(LeagueType::class, 'id', 'league_type_id');
    }

    public function marketType()
    {
        return $this->hasOne(MarketType::class, 'id', 'market_type_id');
    }

    public function scoreType()
    {
        return $this->hasOne(ScoreType::class, 'id', 'score_type_id');
    }

    
    // public function selectedBy(User $user)
    // {
    //     return $this->userSetting->contains('user_id', $user->id);
    // }

    // public function leagueOwnedBy(User $user)
    // {
    //     return $this->leagues->contains('user_id', $user->id); 
    // }

    //relationship to retrieve the user setting (for now the seleceted league)
    // public function userSetting()
    // {
    //     return $this->hasOne(UserSetting::class);
    // }

    // public function invitations()
    // {
    //     return $this->hasManyThrough(Invitation::class, UserSetting::class, 'league_id', 'league_id'); 
    // }

    // public function invitationsLeague() //better to call this method sentInvitation()
    // {
    //     return $this->hasMany(Invitation::class);
    // }

    // public function sentinvitations() //better to call this method sentInvitation()
    // {
    //     return $this->hasManyThrough(Invitation::class, League::class, 'league_id', 'league_id')->withTrashed();
    // }

   

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    // public function rosters()
    // {
    //     return $this->hasManyThrough(Team::class, Market::class, 'team_id', 'league_id', 'id', 'player_id');
    // }

    public function rosters($league)
    {
        return $this->hasManyThrough(Market::class, Team::class, 'id', 'team_id', 'id', 'league_id')->where('league_id', $league->id);
    }

    // public function team()
    // {
    //     return $this->belongsTo(team::class);
    // }

   


    





}

