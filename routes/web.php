<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\League\LeagueController;
use App\Http\Controllers\InvitationReceivedController;
use App\Http\Controllers\League\LeagueTrashController;
use App\Http\Controllers\League\LeagueSelectController;
use App\Http\Controllers\Invitation\InvitationTrashController;
use App\Http\Controllers\Invitation\InvitationController;

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
Route::group(['middleware' => 'auth', 'verified'], function() {

    Route::get('/dashboard', function () {//This will go to the controller
        return view('dashboard/dashboard');
    })->name('dashboard');

    Route::get('/market', function () {//This will go to the controller
        return view('market');
    })->name('market');

    Route::get('/roster', function () {//This will go to the controller
        return view('roster');
    })->name('roster');

    Route::get('/lineup', function () {//This will go to the controller
        return view('lineup');
    })->name('lineup');

    Route::get('/matches', function () {//This will go to the controller
        return view('matches');
    })->name('matches');

    Route::get('/standings', function () {//This will go to the controller
        return view('standings');
    })->name('standings');

    Route::get('/league', function () {//This will go to the controller
        return view('league');
    })->name('league');



    //This is new Laravel 9 feature: I used [LeagueController::class] only once, when we groups ruotes
    Route::controller(LeagueController::class)->group(function () {

        Route::get('/leagues', 'index')->name('leagues');
        Route::get('/leagues/create', 'create')->name('leagues.create');//form to create a league
        
        //TODO - Logic for updating league info (league admin can mod name budget and more)
        Route::get('/league/{league:name}/edit', 'edit')->name('league.edit');
        Route::put('/league/{league}/update', 'update')->name('league.update');

        Route::post('/league', 'store');
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

        Route::get('/team/create', 'create')->name('team.create');//form to create a team
        Route::post('/team', 'store');

        Route::get('/team/{team}', 'edit')->name('team.edit');//form to modify team
        Route::put('/team/{team}', 'update')->name('team.update');
        Route::delete('/team/{team}', 'destroy')->name('team.destroy');
    });

    //League Admin
    Route::controller(InvitationController::class)->group(function () {

        Route::get('/invitations', 'index')->name('invitations');

        //TODO - Create a middleware that checks if user is league admin of selected league
        Route::get('/invitations/create', 'create')->name('invitations.create');//form to create an invitation
        
        Route::post('/invitation', 'store')->name('invitation.store');
        Route::delete('/invitation/{invitation}', 'softDelete')->name('invitation.softDelete');
    });


    Route::controller(InvitationReceivedController::class)->group(function () {
        
        Route::put('/invitation/{invitation}/accept', 'accept')->name('invitation.accept');
        Route::put('/invitation/{invitation}/decline', 'decline')->name('invitation.decline');

    });

    // Route::controller(TrashController::class)->middleware(['auth', 'verified'])->group(function () {

    //     Route::get('/invitations/trash', 'index')->name('invitations.trash');//trash page
    //     Route::put('/invitation/trash/{invitation}/restore', 'restore')->name('invitation.restore')->withTrashed();
    //     Route::delete('/invitation/trash/{invitation}/destroy', 'forceDelete')->name('invitation.forceDelete')->withTrashed();
    // });

    Route::controller(InvitationTrashController::class)->group(function () {

        Route::get('/invitations/trash', 'index')->name('invitations.trash');//trash page
        Route::put('/invitation/trash/{invitation}/restore', 'restore')->name('invitation.restore')->withTrashed();
        Route::delete('/invitation/trash/{invitation}/destroy', 'forceDelete')->name('invitation.forceDelete')->withTrashed();
    });

});

require __DIR__.'/auth.php';
