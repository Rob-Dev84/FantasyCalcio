<?php

namespace App\Http\Controllers\Lineup;

use Illuminate\Http\Request;
// use App\Models\Lineup\Module;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lineup\StoreLineupModelRequest;

class LineupModuleController extends Controller
{

    public function __construct()
    {
        //MIddleware works here but not in web.php file
        $this->middleware(['auth', 'verified']);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreLineupModelRequest $request)
    {

        // $request->user()->team->module()->create($request->only('module_type_id'));

        //Update Or Create
        $request->user()->team->module()->updateOrCreate(
            [
                'team_id' => $request->user()->team->id,
            ],
            [
                'module_type_id' => $request->module_type_id,
                'team_id' => $request->user()->team->id,
            ],
        );

        //TODO - Change player status
        
        // if team has 4-4-3 and than the user changes the module. 3-5-2, 
        // chenge the last defender the status to null


        return back();
    }

    
}
