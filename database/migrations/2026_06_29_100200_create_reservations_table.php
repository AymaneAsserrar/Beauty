<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Réservations : lie un client, un prestataire et une prestation à un créneau.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Le client qui réserve.
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Le prestataire assigné au rendez-vous.
            $table->foreignId('prestataire_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // La prestation réservée.
            $table->foreignId('prestation_id')
                  ->constrained('prestations')
                  ->cascadeOnDelete();

            // Créneau : date + heure de début du rendez-vous.
            $table->dateTime('date_heure');

            // Statut du rendez-vous.
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'terminee'])
                  ->default('en_attente');

            $table->text('notes')->nullable(); // remarque éventuelle du client
            $table->timestamps();

            // Sécurité anti double-réservation : un prestataire ne peut pas
            // avoir deux RDV au même créneau exact.
            $table->unique(['prestataire_id', 'date_heure']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
