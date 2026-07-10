<?php

namespace App\Livewire;

use App\Models\Avis;
use App\Models\Reservation;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LeaveReview extends Component
{
    /** La réservation (terminée) concernée par l'avis. */
    public Reservation $reservation;

    /** Affiche ou masque le formulaire d'avis. */
    public bool $showForm = false;

    #[Validate('required|integer|min:1|max:5')]
    public int $note = 5;

    #[Validate('nullable|string|max:1000')]
    public string $commentaire = '';

    public function mount(Reservation $reservation): void
    {
        $this->reservation = $reservation;
    }

    /**
     * Enregistre l'avis du client pour cette réservation.
     */
    public function enregistrer(): void
    {
        // Sécurité : seul le client propriétaire d'une réservation terminée
        // et non encore notée peut déposer un avis.
        abort_unless($this->reservation->client_id === auth()->id(), 403);

        if (! $this->reservation->estNotable()) {
            session()->flash('error', "Cette réservation ne peut pas être notée.");
            return;
        }

        $this->validate();

        Avis::create([
            'reservation_id' => $this->reservation->id,
            'client_id'      => auth()->id(),
            'prestation_id'  => $this->reservation->prestation_id,
            'note'           => $this->note,
            'commentaire'    => $this->commentaire ?: null,
        ]);

        $this->showForm = false;
        session()->flash('status', 'Merci pour votre avis !');

        // Rafraîchit l'état (la réservation n'est plus notable).
        $this->reservation->refresh();
    }

    public function render()
    {
        return view('livewire.leave-review');
    }
}
