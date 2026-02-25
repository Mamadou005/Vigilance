<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // On désactive temporairement le mode strict pour éviter l'erreur "Data truncated"
        DB::statement('SET SESSION sql_mode = ""');

        Schema::table('agents', function (Blueprint $table) {
            // On change ENUM en STRING (VARCHAR 255)
            // Cela acceptera 'Repos', 'Actif', ou n'importe quel texte sans erreur
            $table->string('statut', 50)->default('Actif')->change();
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->enum('statut', ['Actif', 'Inactif'])->default('Actif')->change();
        });
    }
};
