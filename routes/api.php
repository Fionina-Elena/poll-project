<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::post('/polls', [PollController::class, 'store']);
Route::get('/polls/{short_code}', [PollController::class, 'show']);
Route::post('/polls/{short_code}/vote', [PollController::class, 'vote']);
