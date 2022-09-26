<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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


}
