<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PokemonPrediction;
use Illuminate\Support\Facades\Auth;

class PokemonPredictController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        // =============================
        // SIMULASI AI / ML
        // =============================
        // Nantinya bisa diganti:
        // - Python (TensorFlow / PyTorch)
        // - API eksternal
        // - FastAPI
        $fakePrediction = collect([
            'pikachu',
            'bulbasaur',
            'charmander',
            'squirtle'
        ])->random();

        // =============================
        // SIMPAN KE DATABASE
        // =============================
        $prediction = PokemonPrediction::create([
            'user_id' => Auth::id(),
            'label'   => $fakePrediction
        ]);

        return response()->json([
            'success' => true,
            'prediction' => $prediction->label
        ]);
    }
}
