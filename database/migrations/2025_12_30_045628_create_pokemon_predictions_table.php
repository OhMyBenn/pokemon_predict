<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pokemon_predictions', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label'); // nama pokemon hasil prediksi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_predictions');
    }
};
