<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chambres', function (Blueprint $table) {
            $table->id();
            // ou se trouve l'image
            $table->string('nom');
            $table->string('img_path');
            $table->string('nbr_personnes');
            $table->string('nbr_lit');
            $table->string('nbr_sdb');
            $table->string('description');
            $table->boolean('disponible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
