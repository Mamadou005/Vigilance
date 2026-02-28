<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Créer un utilisateur admin par défaut
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@vigilance-cos.com',
            'password' => Hash::make('Admin@2026'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer l'utilisateur admin par défaut
        User::where('email', 'admin@vigilance-cos.com')->delete();
    }
};
