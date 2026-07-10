<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'prestataire_id',
        'prestation_id',
        'date_heure',
        'statut',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_heure' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function prestataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }

    public function prestation(): BelongsTo
    {
        return $this->belongsTo(Prestation::class);
    }

    public function avis(): HasOne
    {
        return $this->hasOne(Avis::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers de statut
    |--------------------------------------------------------------------------
    */

    public function estAnnulable(): bool
    {
        // Annulable tant qu'elle n'est pas déjà annulée/terminée et qu'elle est à venir.
        return in_array($this->statut, ['en_attente', 'confirmee'])
            && $this->date_heure->isFuture();
    }

    /**
     * Le client peut laisser un avis si la prestation est terminée
     * et qu'aucun avis n'a encore été déposé.
     */
    public function estNotable(): bool
    {
        return $this->statut === 'terminee' && $this->avis === null;
    }

    /**
     * Libellé lisible du statut (pour l'affichage).
     */
    public function statutLabel(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirmee'  => 'Confirmée',
            'annulee'    => 'Annulée',
            'terminee'   => 'Terminée',
            default      => $this->statut,
        };
    }
}
