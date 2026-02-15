<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remplacements', function (Blueprint $table) {
            // Ces 3 lignes "débloquent" la base de données
            $table->unsignedBigInteger('agent_absent_id')->nullable()->change();
            $table->unsignedBigInteger('agent_remplacant_id')->nullable()->change();
            $table->string('statut')->nullable()->change();

            // On s'assure que n_wave est bien créé
            if (!Schema::hasColumn('remplacements', 'n_wave')) {
                $table->string('n_wave')->nullable();
            }
            if (!Schema::hasColumn('remplacements', 'agent_remplace_nom')) {
                $table->string('agent_remplace_nom')->nullable();
            }
        });
    }

    public function down(): void {}
};
