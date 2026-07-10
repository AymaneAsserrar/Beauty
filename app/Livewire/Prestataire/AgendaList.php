<?php

namespace App\Livewire\Prestataire;

use App\Models\Reservation;
use Livewire\Component;

class AgendaList extends Component
{
    /** Onglet courant : 'a_venir' ou 'passes'. */
    public string $vue = 'a_venir';

    /**
     * Le prestataire marque un rendez-vous comme confirmé ou terminé.
     */
    public function marquer(int $id, string $statut): void
    {
        if (! in_array($statut, ['confirmee', 'terminee'], true)) {
            return;
        }

        // Sécurité : seul le prestataire propriétaire du RDV peut le modifier.
        $reservation = Reservation::where('prestataire_id', auth()->id())->findOrFail($id);
        $reservation->update(['statut' => $statut]);

        session()->flash('status', 'Rendez-vous mis à jour.');
    }

    public function render()
    {
        $query = Reservation::with(['client', 'prestation'])
            ->where('prestataire_id', auth()->id());

        if ($this->vue === 'a_venir') {
            $query->where('date_heure', '>=', now())->orderBy('date_heure');
        } else {
            $query->where('date_heure', '<', now())->orderByDesc('date_heure');
        }

        return view('livewire.prestataire.agenda-list', [
            'reservations' => $query->get(),
        ]);
    }
}
