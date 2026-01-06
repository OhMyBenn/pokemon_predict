<?php

namespace App\Models;

use App\Models\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonPrediction extends Model
{
    use HasFactory;
     protected $fillable = ['input_id', 'label', 'confidence'];

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class);
    }
}
