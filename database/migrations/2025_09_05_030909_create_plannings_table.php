<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');

            // Colonnes Statut (F/R)
            $table->string('lundi')->default('R');
            $table->string('mardi')->default('R');
            $table->string('mercredi')->default('R');
            $table->string('jeudi')->default('R');
            $table->string('vendredi')->default('R');
            $table->string('samedi')->default('R');
            $table->string('dimanche')->default('R');

            // Colonnes Horaires Spécifiques
            $table->string('h_lundi')->nullable();
            $table->string('h_mardi')->nullable();
            $table->string('h_mercredi')->nullable();
            $table->string('h_jeudi')->nullable();
            $table->string('h_vendredi')->nullable();
            $table->string('h_samedi')->nullable();
            $table->string('h_dimanche')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};
