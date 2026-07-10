<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Avis : un client note et commente une prestation qu'il a terminée.
     */
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();

            // La réservation (terminée) à l'origine de l'avis : un avis par réservation.
            $table->foreignId('reservation_id')
                  ->unique()
                  ->constrained('reservations')
                  ->cascadeOnDelete();

            // Le client qui laisse l'avis.
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // La prestation notée (dénormalisée pour faciliter les moyennes/affichage).
            $table->foreignId('prestation_id')
                  ->constrained('prestations')
                  ->cascadeOnDelete();

            // Note de 1 à 5 étoiles.
            $table->unsignedTinyInteger('note');

            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
