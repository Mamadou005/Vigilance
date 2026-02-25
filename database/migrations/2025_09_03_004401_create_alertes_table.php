<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // intrusion / incendie / autre
            $table->string('site')->nullable();
            $table->dateTime('date_alerte');
            $table->boolean('traitee')->default(false);
            $table->text('rapport')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alertes');
    }
};
