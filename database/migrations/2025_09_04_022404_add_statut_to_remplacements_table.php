<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('remplacements', function (Blueprint $table) {
            $table->string('statut')->after('date_remplacement');
        });
    }

    public function down()
    {
        Schema::table('remplacements', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }

};
