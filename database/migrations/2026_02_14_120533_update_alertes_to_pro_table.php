<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alertes', function (Blueprint $table) {
            // 1. On garde 'site' mais on ajoute 'site_id' pour la relation pro
            if (!Schema::hasColumn('alertes', 'site_id')) {
                $table->foreignId('site_id')->nullable()->constrained('sites')->onDelete('cascade');
            }

            // 2. On ajoute les champs de ton image s'ils n'existent pas
            if (!Schema::hasColumn('alertes', 'type_incident')) {
                $table->string('type_incident')->nullable();
            }
            if (!Schema::hasColumn('alertes', 'heure_incident')) {
                $table->string('heure_incident')->nullable();
            }
            if (!Schema::hasColumn('alertes', 'heure_arrivee_brigade')) {
                $table->string('heure_arrivee_brigade')->nullable();
            }
            if (!Schema::hasColumn('alertes', 'intervenant_nom')) {
                $table->string('intervenant_nom')->nullable();
            }
            if (!Schema::hasColumn('alertes', 'statut')) {
                $table->string('statut')->default('non_traite');
            }
            if (!Schema::hasColumn('alertes', 'observations')) {
                $table->text('observations')->nullable();
            }

            // 3. On s'assure que 'traitee' existe pour le Dashboard
            if (!Schema::hasColumn('alertes', 'traitee')) {
                $table->boolean('traitee')->default(false);
            }
        });
    }

    public function down(): void {
        // Optionnel : ce qu'il faut faire en cas de rollback
    }
};
