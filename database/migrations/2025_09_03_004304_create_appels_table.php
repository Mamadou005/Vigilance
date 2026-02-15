<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('appels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->dateTime('date_appel');
            $table->boolean('present')->default(false);
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('appels');
    }
};
