<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestation extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'duree',
        'image',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'prix'   => 'decimal:2',
            'duree'  => 'integer',
            'active' => 'boolean',
        ];
    }

    /**
     * Scope : prestations visibles dans le catalogue public.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Réservations liées à cette prestation.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Avis laissés sur cette prestation.
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Note moyenne (1 à 5), arrondie à une décimale, ou null si aucun avis.
     */
    public function noteMoyenne(): ?float
    {
        // Utilise la relation déjà chargée si disponible, sinon interroge la base.
        $moyenne = $this->relationLoaded('avis')
            ? $this->avis->avg('note')
            : $this->avis()->avg('note');

        return $moyenne !== null ? round((float) $moyenne, 1) : null;
    }

    /**
     * Nombre total d'avis.
     */
    public function nombreAvis(): int
    {
        return $this->relationLoaded('avis')
            ? $this->avis->count()
            : $this->avis()->count();
    }
}
