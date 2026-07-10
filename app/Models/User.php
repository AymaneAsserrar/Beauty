<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Attributs autorisés en assignation de masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
    ];

    /**
     * Attributs masqués lors de la sérialisation (JSON, tableaux).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversion automatique de certains champs (dates, hachage du mot de passe).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers de rôle
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPrestataire(): bool
    {
        return $this->role === 'prestataire';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Réservations passées par cet utilisateur en tant que client.
     */
    public function reservationsClient(): HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    /**
     * Rendez-vous attribués à cet utilisateur en tant que prestataire.
     */
    public function reservationsPrestataire(): HasMany
    {
        return $this->hasMany(Reservation::class, 'prestataire_id');
    }
}
