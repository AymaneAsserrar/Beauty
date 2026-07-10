<?php

namespace App\Livewire;

use App\Models\Reservation;
use Livewire\Component;

class ClientReservations extends Component
{
    /**
     * Annule une réservation appartenant au client connecté.
     */
    public function annuler(int $reservationId): void
    {
        $reservation = Reservation::where('client_id', auth()->id())
            ->findOrFail($reservationId);

        // On vérifie qu'elle est bien annulable (à venir et non déjà annulée/terminée).
        if (! $reservation->estAnnulable()) {
            session()->flash('error', "Cette réservation ne peut plus être annulée.");
            return;
        }

        $reservation->update(['statut' => 'annulee']);

        session()->flash('status', 'Réservation annulée.');
    }

    public function render()
    {
        $reservations = Reservation::with(['prestation', 'prestataire'])
            ->where('client_id', auth()->id())
            ->orderByDesc('date_heure')
            ->get();

        return view('livewire.client-reservations', [
            'reservations' => $reservations,
        ]);
    }
}
