<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PlayerStatsController;
use App\Http\Controllers\PlayByPlayController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Permissions routes

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //Roles routes

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');

    //User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

    //Tournament routes
    // Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournament.store');
    Route::get('/tournaments/{id}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::post('/tournaments/{id}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    //Team routes
    // Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams', [TeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('/teams-by-tournament', [TeamController::class, 'getByTournament'])->name('teams.by_tournament');

    //Player routes
    // Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players/{id}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');

    Route::get('/players-by-team', [PlayerController::class, 'getByTeam'])->name('players.by_team');


    //Schedule routes
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    Route::post('/schedules/store-game-time', [ScheduleController::class, 'storeGameTime'])->name('schedules.storeGameTime');
    Route::get('/getGameDetails/{scheduleId}', [ScheduleController::class, 'getGameDetails']);

    //Player Stats routes
    Route::get('/playerstats', [PlayerStatsController::class, 'index'])->name('playerstats.index');
    Route::get('/playerstats/create/{schedule_id}', [PlayerStatsController::class, 'create'])->name('playerstats.create');
    Route::post('/playerstats', [PlayerStatsController::class, 'store'])->name('playerstats.store');
    // Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    // Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
    // Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    Route::get('/playbyplay/{scheduleId}', [PlayByPlayController::class, 'getPlayByPlay'])->name('playbyplay.get');

});

require __DIR__.'/auth.php';
