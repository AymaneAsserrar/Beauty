<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('prestations.index') }}" wire:navigate
        class="text-sm font-medium text-ninich-rose hover:underline">&larr; Retour au catalogue</a>

    <div class="text-center mt-4 mb-8">
        <h1 class="font-serif text-4xl font-bold">Réserver votre rendez-vous</h1>
        <p class="text-ninich-muted mt-2">Complétez les étapes ci-desuus pour confirmer votre créneau.</p>
    </div>

    @php $prestataireChoisi = $this->prestataires->firstWhere('id', (int) $prestataire_id); @endphp

    <form wire:submit="reserver" class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-8 items-start">

        {{-- COLONNE GAUCHE : étapes --}}
        <div class="space-y-6">

            {{-- 1. Prestataire --}}
            <div class="bg-white border border-ninich-line rounded-[22px] p-7 shadow-ninich">
                <h2 class="font-serif text-xl font-bold mb-1">1. Choisissez votre experte</h2>
                <p class="text-sm text-ninich-muted mb-5">Sélectionnez la prestataire qui réalisera votre soin.</p>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ($this->prestataires as $p)
                        <button type="button" wire:click="$set('prestataire_id', '{{ $p->id }}')"
                            class="flex items-center gap-4 text-left border-2 rounded-2xl p-4 transition
                                    {{ (int) $prestataire_id === $p->id ? 'border-ninich-rose bg-ninich-blush' : 'border-ninich-line hover:border-ninich-rose/50' }}">
                            <div
                                class="w-12 h-12 rounded-full bg-ninich-blush-2 flex items-center justify-center text-lg shrink-0">
                                👩‍🔬</div>
                            <div class="flex-1">
                                <b class="text-[15px] block">{{ $p->name }}</b>
                                @if ($p->bio)
                                    <span class="text-xs text-ninich-muted">{{ $p->bio }}</span>
                                @endif
                            </div>
                            @if ((int) $prestataire_id === $p->id)
                                <span
                                    class="w-6 h-6 rounded-full bg-ninich-rose text-white flex items-center justify-center text-sm">✓</span>
                            @endif
                        </button>
                    @endforeach
                </div>
                @error('prestataire_id')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2. Date --}}
            <div class="bg-white border border-ninich-line rounded-[22px] p-7 shadow-ninich">
                <h2 class="font-serif text-xl font-bold mb-1">2. Sélectionnez une date</h2>
                <p class="text-sm text-ninich-muted mb-5">Choisissez le jour de votre rendez-vous.</p>
                <input type="date" wire:model.live="date" min="{{ now()->format('Y-m-d') }}"
                    class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                @error('date')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Créneaux --}}
            <div class="bg-white border border-ninich-line rounded-[22px] p-7 shadow-ninich">
                <h2 class="font-serif text-xl font-bold mb-1">3. Choisissez un créneau</h2>
                <p class="text-sm text-ninich-muted mb-5">Durée du soin : {{ $prestation->duree }} min.</p>

                @if (!$prestataire_id || !$date)
                    <p class="text-sm text-ninich-muted">Sélectionnez d'abord une experte et une date.</p>
                @elseif (count($this->creneaux) === 0)
                    <p class="text-sm text-ninich-muted">Aucun créneau disponible ce jour-là.</p>
                @else
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach ($this->creneaux as $creneau)
                            <button type="button" wire:click="selectHeure('{{ $creneau['heure'] }}')"
                                @disabled(!$creneau['disponible'])
                                class="rounded-xl px-3 py-3 text-sm font-semibold border-[1.5px] transition
                                        @if ($heure === $creneau['heure']) bg-ninich-rose text-white border-ninich-rose
                                        @elseif($creneau['disponible']) bg-white text-ninich-ink border-ninich-line hover:border-ninich-rose
                                        @else bg-ninich-blush-2 text-ninich-muted/50 border-transparent cursor-not-allowed line-through @endif">
                                {{ $creneau['heure'] }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex gap-5 mt-4 text-xs text-ninich-muted">
                        <span class="inline-flex items-center gap-1.5"><i
                                class="inline-block w-3 h-3 rounded bg-ninich-rose"></i>Sélectionné</span>
                        <span class="inline-flex items-center gap-1.5"><i
                                class="inline-block w-3 h-3 rounded bg-white border border-ninich-line"></i>Disponible</span>
                        <span class="inline-flex items-center gap-1.5"><i
                                class="inline-block w-3 h-3 rounded bg-ninich-blush-2"></i>Indisponible</span>
                    </div>
                @endif
                @error('heure')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- 4. Notes --}}
            <div class="bg-white border border-ninich-line rounded-[22px] p-7 shadow-ninich">
                <h2 class="font-serif text-xl font-bold mb-1">4. Une remarque ?</h2>
                <p class="text-sm text-ninich-muted mb-5">Facultatif — précisez une demande particulière.</p>
                <textarea wire:model="notes" rows="3"
                    class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose"
                    placeholder="Ex : peau sensible, allergie à certains produits…"></textarea>
                @error('notes')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- COLONNE DROITE : récapitulatif --}}
        <aside class="lg:sticky lg:top-6">
            <div class="bg-white border border-ninich-line rounded-[22px] overflow-hidden shadow-ninich">
                @if ($prestation->image)
                    <img src="{{ $prestation->image }}" alt="{{ $prestation->nom }}" class="h-40 w-full object-cover">
                @endif
                <div class="p-6">
                    <h3 class="font-serif text-2xl font-bold">{{ $prestation->nom }}</h3>
                    <div class="my-5 border-y border-dashed border-ninich-line py-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between"><span class="text-ninich-muted">👩‍🔬
                                Experte</span><b>{{ $prestataireChoisi->name ?? '—' }}</b></div>
                        <div class="flex items-center justify-between"><span class="text-ninich-muted">📅
                                Date</span><b>{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('D d M Y') : '—' }}</b>
                        </div>
                        <div class="flex items-center justify-between"><span class="text-ninich-muted">🕒
                                Heure</span><b>{{ $heure ?: '—' }}</b></div>
                        <div class="flex items-center justify-between"><span class="text-ninich-muted">⏱
                                Durée</span><b>{{ $prestation->duree }} min</b></div>
                    </div>
                    <div class="flex items-baseline justify-between mb-5">
                        <span class="text-ninich-muted text-sm">Total</span>
                        <b class="font-serif text-3xl text-ninich-rose-dark">{{ number_format($prestation->prix, 2, ',', ' ') }}
                            €</b>
                    </div>
                    <button type="submit"
                        class="w-full rounded-full bg-ninich-rose px-6 py-4 text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="reserver">Confirmer la réservation</span>
                        <span wire:loading wire:target="reserver">Enregistrement…</span>
                    </button>
                    <p class="text-xs text-ninich-muted text-center mt-3">Vous recevrez une confirmation. Annulation
                        gratuite jusqu'à 24 h avant.</p>
                </div>
            </div>
        </aside>
    </form>
</div>
