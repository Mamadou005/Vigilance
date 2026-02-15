<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('date_rapport');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rapports');
    }
};
