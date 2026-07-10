<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
