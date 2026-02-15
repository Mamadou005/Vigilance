<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remplacements', function (Blueprint $table) {
            // On rend TOUS les anciens champs optionnels d'un coup pour ne plus être bloqué
            $table->date('date_remplacement')->nullable()->change();
            $table->unsignedBigInteger('agent_absent_id')->nullable()->change();
            $table->unsignedBigInteger('agent_remplacant_id')->nullable()->change();
            $table->string('statut')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Pas besoin de remplir le down pour une correction rapide
    }
};
