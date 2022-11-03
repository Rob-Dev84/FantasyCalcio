<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\League\LeagueController;
use App\Http\Controllers\Lineup\LineupController;
use App\Http\Controllers\Market\MarketController;
use App\Http\Controllers\Roster\RosterController;
// use App\Http\Controllers\InvitationReceivedController;
use App\Http\Controllers\League\LeagueTrashController;
use App\Http\Controllers\League\LeagueSelectController;
use App\Http\Controllers\Lineup\LineupModuleController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\Invitation\InvitationTrashController;
use App\Http\Controllers\Invitation\InvitationReceivedController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::get('/', function () {
    
    return view('welcome');
});




//Group all routes in this application with middleware

//FIXME - middleware don't seems to work in here, but it works om each controller
Route::middleware(['auth', 'verified'])->group(function () {
    // Route::middleware(['auth', 'verified'])->group(['middleware' => ['auth', 'verified']], function () {
        
    Route::get('/dashboard', function () {//This will go to the controller
        return view('dashboard/dashboard');
    })->name('dashboard');
    

    // Route::get('/league', function () {//This will go to the controller
    //     return view('league');
    // })->name('league');


    //This is new Laravel 9 feature: I used [LeagueController::class] only once, when we groups ruotes
    Route::controller(LeagueController::class)->group(function () {

        Route::get('/leagues', 'index')->name('leagues');
        Route::get('/leagues/create', 'create')->name('leagues.create');//form to create a league
        
        //TODO - Logic for updating league info (league admin can mod name budget and more)
        Route::get('/league/{league:name}/edit', 'edit')->name('league.edit');
        Route::put('/league/{league}/update', 'update')->name('league.update');

        Route::post('/leagues/create', 'store')->name('leagues.store');
        Route::delete('/leagues/{league}/softDelete', 'softDelete')->name('leagues.softDelete');
    });

    Route::controller(LeagueTrashController::class)->group(function () {
        
        Route::get('/leagues/trash', 'index')->name('leagues.trash');//trash page
        Route::put('/league/{league}/restore', 'restore')->name('league.restore')->withTrashed();
        Route::put('/league/{league}/forceDelete', 'forceDelete')->name('league.forceDelete')->withTrashed();

    });

    Route::put('/leagues/{league}/select', [LeagueSelectController::class, 'update'])->name('leagues.select');

    Route::controller(TeamController::class)->group(function () {
        Route::get('/team', 'index')->name('team');

        Route::get('/team/{league:name}', 'create')->name('team.create');//form to create a team
        Route::post('/team/{league:name}', 'store')->name('team.store');

        Route::get('/team/{team:name}/edit', 'edit')->name('team.edit');//form to modify team
        Route::put('/team/{team:name}', 'update')->name('team.update');
        Route::delete('/team/{team:name}', 'destroy')->name('team.destroy');
    });

    //League Admin
    Route::controller(InvitationController::class)->group(function () {

        Route::get('/invitations', 'index')->name('invitations');

        //TODO - Create a middleware that checks if user is league admin of selected league
        Route::get('/invitations/create', 'create')->name('invitations.create');//form to create an invitation
        
        Route::post('/invitation/{league:name}', 'store')->name('invitation.store');
        Route::delete('/invitation/{invitation}', 'softDelete')->name('invitation.softDelete');
    });


    Route::controller(InvitationReceivedController::class)->group(function () {
        
        Route::put('/invitation/{invitation}/accept', 'accept')->name('invitation.accept');
        Route::put('/invitation/{invitation}/decline', 'decline')->name('invitation.decline');

    });
    

    Route::controller(InvitationTrashController::class)->group(function () {

        Route::get('/invitations/trash', 'index')->name('invitations.trash');//TODO - add a middleware that allows to access the page only is user selects the league
        Route::put('/invitation/trash/{invitation}/restore', 'restore')->name('invitation.restore')->withTrashed();
        Route::delete('/invitation/trash/{invitation}/destroy', 'forceDelete')->name('invitation.forceDelete')->withTrashed();
    });

    Route::controller(MarketController::class)->group(function () {

        Route::get('/markets/{league:name}/{team:name}', 'index')->name('markets');
        // Route::post('/markets/{league:name}/search', 'search');
        Route::post('/markets/{league:name}/{team:name}/{player}', 'buy')->name('markets.buy');//form to buy a player
        Route::delete('/markets/{league:name}/{team:name}/{player}/sell', 'sell')->name('markets.sell');
        
    });

    Route::controller(RosterController::class)->group(function () {
        Route::get('/rosters/{league:name}', 'index')->name('rosters');
    });

    Route::controller(LineupController::class)->group(function () {
        Route::get('/lineups/{league:name}/all', 'index')->name('lineups');//show all the lineups (latest per date)

        // Route::get('/lineups/{league:name}/{currentFixture}/all', 'index')->name('lineups');//show all the lineups (latest per date)
        // Route::get('/lineups/{league:name}/{fixture}/all', 'edit')->name('lineups.edit');//show all the lineups (per fixture selected)

        //TODO - Create a middleware that checks current timestamp between 'start'/'end' curretn fixture
        Route::get('/lineup/{league:name}/{team:name}', 'create')->name('lineup');//lineup single team
        Route::post('/lineup/{league:name}/{team:name}/{fixture}/{player}/pitch', 'pitch')->name('lineup.pitch');
        Route::post('/lineup/{league:name}/{team:name}/{fixture}/{player}/bench', 'bench')->name('lineup.bench');
        Route::delete('/lineup/{league:name}/{team:name}/{fixture}/{player}/undo', 'undo')->name('lineup.undo');
    });

    Route::controller(LineupModuleController::class)->group(function () {
        Route::post('/lineup/module', 'store')->name('module.store');
    });

    // Route::get('/lineup', function () {//This will go to the controller
    //     return view('lineup');
    // })->name('lineup');

    Route::get('/matches', function () {//This will go to the controller
        return view('matches');
    })->name('matches');

    Route::get('/standings', function () {//This will go to the controller
        return view('standings');
    })->name('standings');

});

require __DIR__.'/auth.php';
