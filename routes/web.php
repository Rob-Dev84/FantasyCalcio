<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\LeagueSelectController;

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

Route::get('/dashboard', function () {//This will go to the controller
    return view('dashboard/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/market', function () {//This will go to the controller
    return view('market');
})->middleware(['auth', 'verified'])->name('market');

Route::get('/roster', function () {//This will go to the controller
    return view('roster');
})->middleware(['auth', 'verified'])->name('roster');

Route::get('/lineup', function () {//This will go to the controller
    return view('lineup');
})->middleware(['auth', 'verified'])->name('lineup');

Route::get('/matches', function () {//This will go to the controller
    return view('matches');
})->middleware(['auth', 'verified'])->name('matches');

Route::get('/standings', function () {//This will go to the controller
    return view('standings');
})->middleware(['auth', 'verified'])->name('standings');

Route::get('/league', function () {//This will go to the controller
    return view('league');
})->middleware(['auth', 'verified'])->name('league');



//This is new Laravel 9 feature: I used [LeagueController::class] only once, when we groups ruotes
Route::controller(LeagueController::class)->middleware(['auth', 'verified'])->group(function () {

    Route::get('/leagues', 'index')->name('leagues');
    // Route::get('/leagues{league}', 'show')->name('leagues.show');
    Route::post('/league', 'store');
    
    Route::delete('/leagues/{league}/softDelete', 'softDelete')->name('leagues.softDelete');
    Route::post('/leagues/{league}/restore', 'restore')->name('leagues.restore');
    Route::delete('/leagues/{league}/forceDelete', 'forceDelete')->name('leagues.forceDelete');//We're using the {id}, but the root model binding {league}
});

Route::put('/leagues/{league}/select', [LeagueSelectController::class, 'update'])->middleware(['auth', 'verified'])->name('leagues.select');

Route::controller(TeamController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/team', 'index')->name('team');

    Route::get('/team/create', 'create')->name('team.create');//form to create a team
    Route::post('/team', 'store');

    Route::get('/team/{team}', 'edit')->name('team.edit');//form to modify team
    Route::put('/team/{team}', 'update')->name('team.update');
    Route::delete('/team/{team}', 'destroy')->name('team.destroy');
});

Route::get('/invitations', function () {
    return view('invitations/invitations');
})->middleware(['auth', 'verified'])->name('invitations');

Route::get('/invite-friend', function () {
    return view('invitations/invite-friend');
})->middleware(['auth', 'verified'])->name('invite-friend');

require __DIR__.'/auth.php';
