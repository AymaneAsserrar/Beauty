<?php

namespace App\Livewire\Admin;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationList extends Component
{
    use WithPagination;

    /** Filtre par statut ('' = tous). */
    public string $statut = '';

    public function updatingStatut(): void
    {
        $this->resetPage();
    }

    /** L'admin change le statut d'une réservation. */
    public function changerStatut(int $id, string $statut): void
    {
        if (! in_array($statut, ['en_attente', 'confirmee', 'annulee', 'terminee'], true)) {
            return;
        }

        Reservation::findOrFail($id)->update(['statut' => $statut]);
        session()->flash('status', 'Statut mis à jour.');
    }

    public function render()
    {
        $reservations = Reservation::with(['client', 'prestataire', 'prestation'])
            ->when($this->statut, fn ($q) => $q->where('statut', $this->statut))
            ->orderByDesc('date_heure')
            ->paginate(15);

        return view('livewire.admin.reservation-list', [
            'reservations' => $reservations,
        ]);
    }
}
