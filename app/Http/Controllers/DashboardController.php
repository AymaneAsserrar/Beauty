<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Redirige l'utilisateur vers le tableau de bord correspondant à son rôle.
     */
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin'       => redirect()->route('admin.reservations'),
            'prestataire' => redirect()->route('prestataire.agenda'),
            default       => redirect()->route('mes-reservations'),
        };
    }
}
