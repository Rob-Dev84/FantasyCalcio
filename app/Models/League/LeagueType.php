<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeagueType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    // public function league()
    // {
    //     return $this->belongsTo(League::class);
    // }

    



}
