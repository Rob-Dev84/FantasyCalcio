<?php

use Illuminate\Support\Facades\Route;

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
// Route::controller(LeagueController::class)->group(function () {
//     Route::get('/leagues', 'index')->name('leagues');
//     Route::get('/leagues{league}', 'show')->name('leagues.show');
//     Route::post('/leagues', 'store');
//     Route::delete('/leagues{leagues}', 'destroy')->name('leagues.destroy');
// });

Route::get('/invitations', function () {
    return view('invitations/invitations');
})->middleware(['auth', 'verified'])->name('invitations');

Route::get('/invite-friend', function () {
    return view('invitations/invite-friend');
})->middleware(['auth', 'verified'])->name('invite-friend');

require __DIR__.'/auth.php';
