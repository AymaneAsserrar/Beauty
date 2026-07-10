<div>
    {{-- Messages flash --}}
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Mes réservations</h2>
        <a href="{{ route('prestations.index') }}" wire:navigate
           class="rounded-full bg-pink-600 px-4 py-2 text-sm text-white font-medium hover:bg-pink-700">
            + Nouvelle réservation
        </a>
    </div>

    @forelse ($reservations as $reservation)
        <div class="mb-3 bg-white rounded-xl ring-1 ring-gray-100 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="font-semibold text-gray-900">{{ $reservation->prestation->nom }}</p>
                <p class="text-sm text-gray-500">
                    avec {{ $reservation->prestataire->name }} ·
                    {{ $reservation->date_heure->translatedFormat('d/m/Y à H:i') }}
                </p>
                @if ($reservation->notes)
                    <p class="text-xs text-gray-400 mt-1 italic">« {{ $reservation->notes }} »</p>
                @endif
            </div>

            <div class="flex items-center gap-3">
                {{-- Badge statut --}}
                @php
                    $couleurs = [
                        'en_attente' => 'bg-yellow-100 text-yellow-700',
                        'confirmee'  => 'bg-green-100 text-green-700',
                        'annulee'    => 'bg-red-100 text-red-700',
                        'terminee'   => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $couleurs[$reservation->statut] ?? '' }}">
                    {{ $reservation->statutLabel() }}
                </span>

                @if ($reservation->estAnnulable())
                    <button wire:click="annuler({{ $reservation->id }})"
                            wire:confirm="Confirmez-vous l'annulation de cette réservation ?"
                            class="text-sm text-red-600 hover:underline">
                        Annuler
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-gray-400">
            Vous n'avez aucune réservation pour le moment.
        </div>
    @endforelse
</div>
