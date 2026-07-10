<?php

namespace App\Livewire;

use App\Models\Prestation;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BookAppointment extends Component
{
    /** Prestation à réserver (injectée via le binding de route). */
    public Prestation $prestation;

    /** ID du prestataire choisi. */
    public ?int $prestataire_id = null;

    /** Date choisie (format Y-m-d). */
    public string $date = '';

    /** Heure choisie (format H:i). */
    public string $heure = '';

    /** Remarque facultative du client. */
    public string $notes = '';

    /** Heures d'ouverture utilisées pour générer les créneaux. */
    public int $ouverture = 9;   // 09:00
    public int $fermeture = 18;  // 18:00
    public int $pas = 30;        // créneaux toutes les 30 min

    /**
     * Initialise le composant avec la prestation issue de l'URL.
     */
    public function mount(Prestation $prestation): void
    {
        abort_unless($prestation->active, 404);

        $this->prestation = $prestation;
        $this->date = now()->addDay()->format('Y-m-d'); // demain par défaut
    }

    /**
     * Liste des prestataires disponibles (rôle = prestataire).
     */
    public function getPrestatairesProperty()
    {
        return User::where('role', 'prestataire')->orderBy('name')->get();
    }

    /**
     * Créneaux horaires disponibles pour le prestataire et la date choisis.
     * On exclut les créneaux qui chevauchent une réservation existante.
     */
    public function getCreneauxProperty(): array
    {
        if (! $this->prestataire_id || ! $this->date) {
            return [];
        }

        $jour = Carbon::parse($this->date);

        // Réservations déjà prises ce jour-là pour ce prestataire.
        $reservations = Reservation::query()
            ->where('prestataire_id', $this->prestataire_id)
            ->whereDate('date_heure', $jour->toDateString())
            ->where('statut', '!=', 'annulee')
            ->with('prestation')
            ->get();

        $duree = $this->prestation->duree;
        $creneaux = [];

        $debut = $jour->copy()->setTime($this->ouverture, 0);
        $finJournee = $jour->copy()->setTime($this->fermeture, 0);

        while ($debut->copy()->addMinutes($duree)->lte($finJournee)) {
            $finCreneau = $debut->copy()->addMinutes($duree);

            // Le créneau est-il dans le passé ?
            $estPasse = $debut->isPast();

            // Chevauche-t-il une réservation existante ?
            $chevauche = $reservations->contains(function ($r) use ($debut, $finCreneau) {
                $rDebut = $r->date_heure;
                $rFin   = $r->date_heure->copy()->addMinutes($r->prestation->duree ?? 30);
                return $debut->lt($rFin) && $finCreneau->gt($rDebut);
            });

            $creneaux[] = [
                'heure'      => $debut->format('H:i'),
                'disponible' => ! $estPasse && ! $chevauche,
            ];

            $debut->addMinutes($this->pas);
        }

        return $creneaux;
    }

    /** Sélectionne un créneau horaire. */
    public function selectHeure(string $heure): void
    {
        $this->heure = $heure;
    }

    /** Si on change de prestataire, l'heure choisie n'est plus valable. */
    public function updatedPrestataireId(): void
    {
        $this->heure = '';
    }

    /** Idem si on change de date. */
    public function updatedDate(): void
    {
        $this->heure = '';
    }

    /**
     * Valide et enregistre la réservation.
     */
    public function reserver()
    {
        $this->validate([
            'prestataire_id' => ['required', 'exists:users,id'],
            'date'           => ['required', 'date', 'after_or_equal:today'],
            'heure'          => ['required'],
            'notes'          => ['nullable', 'string', 'max:500'],
        ], [], [
            'prestataire_id' => 'prestataire',
            'date'           => 'date',
            'heure'          => 'heure',
        ]);

        $dateHeure = Carbon::parse("{$this->date} {$this->heure}");

        // Le créneau doit être dans le futur.
        if ($dateHeure->isPast()) {
            throw ValidationException::withMessages([
                'heure' => 'Ce créneau est déjà passé, choisissez-en un autre.',
            ]);
        }

        // Double-vérification anti double-réservation (en plus de la contrainte SQL).
        $dejaPris = Reservation::where('prestataire_id', $this->prestataire_id)
            ->where('date_heure', $dateHeure)
            ->where('statut', '!=', 'annulee')
            ->exists();

        if ($dejaPris) {
            throw ValidationException::withMessages([
                'heure' => 'Ce créneau vient d\'être réservé. Merci d\'en choisir un autre.',
            ]);
        }

        Reservation::create([
            'client_id'      => auth()->id(),
            'prestataire_id' => $this->prestataire_id,
            'prestation_id'  => $this->prestation->id,
            'date_heure'     => $dateHeure,
            'statut'         => 'en_attente',
            'notes'          => $this->notes ?: null,
        ]);

        session()->flash('status', 'Votre réservation a bien été enregistrée !');

        return $this->redirect(route('mes-reservations'), navigate: true);
    }

    public function render()
    {
        return view('livewire.book-appointment');
    }
}
