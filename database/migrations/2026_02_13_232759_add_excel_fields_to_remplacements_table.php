<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On supprime la table pour repartir sur une base propre
        Schema::dropIfExists('remplacements');

        Schema::create('remplacements', function (Blueprint $table) {
            $table->id();

            // Nouveaux champs Mode Excel
            $table->string('agent_remplace_nom')->nullable();
            $table->string('n_wave')->nullable(); // Votre correction n_wave
            $table->string('poste_nom')->nullable();
            $table->text('motif')->nullable();
            $table->string('agent_remplacant_nom')->nullable();
            $table->string('site_affectation')->nullable();
            $table->date('date_debut')->nullable();
            $table->string('categorie')->default('Postes Vides');

            // Anciens champs rendus optionnels pour compatibilité future
            $table->unsignedBigInteger('agent_absent_id')->nullable();
            $table->unsignedBigInteger('agent_remplacant_id')->nullable();
            $table->string('statut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remplacements');
    }
};
