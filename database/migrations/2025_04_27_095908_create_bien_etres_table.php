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
        Schema::create('bien_etres', function (Blueprint $table) {
            $table->id();
            // ou se trouve l'image
            $table->string('nom');
            // path = /storage/$section/$nom_image
            $table->string('img_path');
            $table->string('litre');
            $table->string('prix');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien_etres');
    }
};
