<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alertes', function (Blueprint $table) {
            // On rajoute l'ancienne colonne 'traitee' sans supprimer 'statut'
            if (!Schema::hasColumn('alertes', 'traitee')) {
                $table->boolean('traitee')->default(false)->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('alertes', function (Blueprint $table) {
            if (Schema::hasColumn('alertes', 'traitee')) {
                $table->dropColumn('traitee');
            }
        });
    }
};
