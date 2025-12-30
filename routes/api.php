<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonPredictController;

Route::middleware('auth:sanctum')->post(
    '/predict-pokemon',
    [PokemonPredictController::class, 'predict']
);

