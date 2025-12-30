<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonPrediction extends Model
{
    protected $fillable = ['user_id', 'label'];
}

