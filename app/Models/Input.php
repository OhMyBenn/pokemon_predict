<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Input extends Model
{
    /** @use HasFactory<\Database\Factories\InputFactory> */
    use HasFactory;

    protected $fillable = ['image'];

    public function predictions(): HasMany
    {
        return $this->hasMany(PokemonPrediction::class);
    }
}