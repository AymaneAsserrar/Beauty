<div>
    {{-- Messages flash --}}
    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-serif text-3xl font-bold text-ninich-ink">Mes réservations</h2>
            <p class="text-sm text-ninich-muted mt-1">Gérez vos rendez-vous et laissez vos avis.</p>
        </div>
        <a href="{{ route('prestations.index') }}" wire:navigate
           class="rounded-full bg-ninich-rose px-5 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">
            + Nouvelle réservation
        </a>
    </div>

    @php
        $couleurs = [
            'en_attente' => 'bg-amber-100 text-amber-700',
            'confirmee'  => 'bg-sky-100 text-sky-700',
            'annulee'    => 'bg-red-100 text-red-700',
            'terminee'   => 'bg-green-100 text-green-700',
        ];
    @endphp

    @forelse ($reservations as $reservation)
        <div class="mb-4 flex flex-col sm:flex-row gap-5 bg-white rounded-[18px] border border-ninich-line p-5 shadow-ninich">
            {{-- Image --}}
            <div class="w-full sm:w-28 h-28 rounded-2xl overflow-hidden bg-ninich-blush-2 flex items-center justify-center shrink-0">
                @if ($reservation->prestation->image)
                    <img src="{{ $reservation->prestation->image }}" alt="{{ $reservation->prestation->nom }}" class="w-full h-full object-cover">
                @else
                    <span class="text-3xl">💅</span>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-serif text-xl font-bold text-ninich-ink">{{ $reservation->prestation->nom }}</h3>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold whitespace-nowrap {{ $couleurs[$reservation->statut] ?? '' }}">
                        ● {{ $reservation->statutLabel() }}
                    </span>
                </div>

                <div class="flex flex-wrap gap-x-5 gap-y-1.5 mt-2 text-[13px] text-ninich-muted">
                    <span>📅 {{ $reservation->date_heure->translatedFormat('D d M Y') }}</span>
                    <span>🕒 {{ $reservation->date_heure->format('H:i') }}</span>
                    <span>⏱ {{ $reservation->prestation->duree }} min</span>
                    <span>👩‍🔬 {{ $reservation->prestataire->name }}</span>
                </div>

                @if ($reservation->notes)
                    <p class="text-xs text-ninich-muted mt-2 italic">« {{ $reservation->notes }} »</p>
                @endif

                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-ninich-line">
                    <span class="font-serif text-xl text-ninich-rose-dark mr-auto">{{ number_format($reservation->prestation->prix, 2, ',', ' ') }} €</span>

                    @if ($reservation->estAnnulable())
                        <button wire:click="annuler({{ $reservation->id }})"
                                wire:confirm="Confirmez-vous l'annulation de cette réservation ?"
                                class="rounded-lg px-4 py-2 text-[13px] font-semibold text-red-600 border-[1.5px] border-red-100 hover:bg-red-50 transition">
                            Annuler
                        </button>
                    @endif

                    {{-- Avis : disponible sur les réservations terminées. --}}
                    @livewire('leave-review', ['reservation' => $reservation], key('avis-'.$reservation->id))
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-ninich-muted bg-white rounded-[18px] border border-ninich-line">
            Vous n'avez aucune réservation pour le moment.
        </div>
    @endforelse
</div>
