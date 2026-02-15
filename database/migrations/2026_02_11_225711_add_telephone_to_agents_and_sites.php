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
        // Ajout du numéro de téléphone pour les Agents
        Schema::table('agents', function (Blueprint $table) {
            if (!Schema::hasColumn('agents', 'telephone')) {
                $table->string('telephone')->nullable()->after('prenom');
            }
        });

        // Ajout du numéro de téléphone RPE pour les Sites
        Schema::table('sites', function (Blueprint $table) {
            if (!Schema::hasColumn('sites', 'telephone')) {
                $table->string('telephone')->nullable()->after('nom')
                    ->comment('Numéro du Responsable Poste Extérieur (RPE)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }
};
