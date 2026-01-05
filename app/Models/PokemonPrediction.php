<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonPrediction extends Model
{
    protected $fillable = ['image', 'label', 'confidence'];
}

