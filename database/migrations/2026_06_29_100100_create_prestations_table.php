<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catalogue des prestations de beauté (géré par l'admin).
     */
    public function up(): void
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                      // ex. "Manucure gel"
            $table->text('description')->nullable();
            $table->decimal('prix', 8, 2);              // ex. 250.00
            $table->unsignedInteger('duree');           // durée en minutes (ex. 60)
            $table->string('image')->nullable();        // chemin/URL de l'image
            $table->boolean('active')->default(true);   // masquer du catalogue sans supprimer
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
