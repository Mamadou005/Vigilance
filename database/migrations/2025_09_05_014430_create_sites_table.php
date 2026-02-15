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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // ex : "BOA Ville", "CBAO Banlieu"

            // Ajout du Secteur pour le regroupement hiérarchique
            $table->enum('secteur', [
                'Secteur 1 (Ville)',
                'Secteur 2 (Banlieu)',
                'Secteur 3 (Region)'
            ]);

            $table->string('adresse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
