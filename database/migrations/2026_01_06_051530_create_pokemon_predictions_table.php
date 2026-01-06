<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('input_id')->constrained('inputs')->onDelete('cascade');
            $table->string('label');
            $table->double('confidence');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_predictions');
    }
};
