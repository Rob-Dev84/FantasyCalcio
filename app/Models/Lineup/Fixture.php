<?php

namespace App\Models\Lineup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture',
        'start',
        'end',
        'league_type_id',
    ];

    // public function lineups()
    // {
    //     return $this->belongsTo(Lineup::class, 'fixture');
    // }
}
