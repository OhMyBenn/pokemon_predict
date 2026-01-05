<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonPredictController;
use App\Http\Controllers\PredictionController;

Route::get('/inputs', [PredictionController::class, 'index']);
Route::get('/inputs/{id}', [PredictionController::class, 'show']);
Route::post('/inputs', [PredictionController::class, 'store']);


Route::post('/predict-pokemon', [PokemonPredictController::class, 'predict']);
