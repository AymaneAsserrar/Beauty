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
}
