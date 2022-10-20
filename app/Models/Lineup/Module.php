<?php

namespace App\Models\Lineup;

use App\Models\Team;
use App\Models\Lineup\ModuleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_type_id',
        'team_id',
    ];



    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function moduleType()
    {
        return $this->hasOne(ModuleType::class, 'id', 'module_type_id');
    }


}
