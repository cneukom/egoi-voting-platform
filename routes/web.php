<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Vote\VotingController;
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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/enter/{token}', [AuthenticatedSessionController::class, 'enter'])
    ->middleware('guest')
    ->name('login_by_token');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/votes', [VotingController::class, 'index'])
    ->middleware('auth')
    ->name('voting.index');

Route::get('/votes/{question}/results', [VotingController::class, 'results'])
    ->middleware('auth')
    ->name('voting.results');

Route::get('/votes/{question}/vote', [VotingController::class, 'vote'])
    ->middleware('nonAdmin')
    ->name('voting.vote');

Route::post('/votes/{question}/vote', [VotingController::class, 'storeVote'])
    ->middleware('nonAdmin');

Route::get('/votes/create', [VotingController::class, 'create'])
    ->middleware('admin')
    ->name('voting.create');

Route::post('/votes/create', [VotingController::class, 'store'])
    ->middleware('admin');

Route::post('/votes/{question}/close', [VotingController::class, 'close'])
    ->middleware('admin')
    ->name('voting.close');
