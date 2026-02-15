<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alertes', function (Blueprint $table) {
            // 1. On supprime d'abord la contrainte de clé étrangère
            if (Schema::hasColumn('alertes', 'agent_id')) {
                $table->dropForeign(['agent_id']); // Supprime le lien
                $table->dropColumn('agent_id');    // Supprime la colonne
            }

            // 2. On nettoie les autres anciennes colonnes
            $columnsToDrop = ['type', 'site', 'traitee', 'commentaire', 'date_alerte'];
            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('alertes', $col)) {
                    $table->dropColumn($col);
                }
            }

            // 3. On ajoute les nouvelles colonnes pro
            $table->foreignId('site_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type_incident')->nullable();
            $table->string('heure_incident')->nullable();
            $table->string('heure_arrivee_brigade')->nullable();
            $table->string('intervenant_nom')->nullable();
            $table->string('statut')->default('non_traite');
            $table->text('observations')->nullable();
        });
    }

    public function down()
    {
        Schema::table('alertes', function (Blueprint $table) {
            // Pour revenir en arrière si besoin
            $table->dropColumn(['site_id', 'type_incident', 'heure_incident', 'heure_arrivee_brigade', 'intervenant_nom', 'statut', 'observations']);
            $table->string('type');
            $table->string('site');
            $table->boolean('traitee')->default(false);
            $table->text('commentaire')->nullable();
        });
    }
};
