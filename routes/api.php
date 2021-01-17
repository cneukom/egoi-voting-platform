<?php

use App\Http\Controllers\Api\EvidenceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/delegation/{delegation}/{token}/contestants/{contestant}/evidence', EvidenceController::class)
    ->only(['store', 'update', 'destroy']);
Route::resource('/contestant/{contestant}/{token}/evidence', EvidenceController::class)
    ->only(['store', 'update']);
Route::get('/evidence/{evidence}', [EvidenceController::class, 'view'])->middleware('auth');
