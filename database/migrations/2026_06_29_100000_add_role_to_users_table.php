<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute le rôle et quelques champs métier à la table users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rôle de l'utilisateur. 'client' par défaut (inscription publique).
            $table->enum('role', ['admin', 'prestataire', 'client'])
                  ->default('client')
                  ->after('email');

            // Champs optionnels (surtout utiles pour le prestataire).
            $table->string('phone')->nullable()->after('role');
            $table->text('bio')->nullable()->after('phone'); // ex. spécialité
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'bio']);
        });
    }
};
