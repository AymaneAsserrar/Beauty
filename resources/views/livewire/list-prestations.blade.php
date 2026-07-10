<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- En-tête --}}
    <div class="text-center max-w-xl mx-auto mb-8">
        <span class="inline-block bg-ninich-blush-2 text-ninich-rose-dark font-semibold text-xs tracking-[0.15em] uppercase px-5 py-2 rounded-full mb-4">Notre catalogue</span>
        <h1 class="font-serif text-4xl sm:text-5xl font-bold">Toutes nos prestations</h1>
        <p class="mt-3 text-ninich-muted">Trouvez le soin idéal parmi notre sélection et réservez en quelques clics.</p>
    </div>

    {{-- Barre de recherche --}}
    <div class="bg-white border border-ninich-line rounded-2xl p-4 shadow-ninich mb-4">
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ninich-muted">🔍</span>
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Rechercher une prestation…"
                   class="w-full rounded-xl border-ninich-line bg-ninich-blush pl-11 pr-4 py-3 text-ninich-ink focus:border-ninich-rose focus:ring-ninich-rose">
        </div>
    </div>
    <p class="text-sm text-ninich-muted mb-6 px-1"><b class="text-ninich-ink">{{ $prestations->total() }} prestation{{ $prestations->total() > 1 ? 's' : '' }}</b> trouvée{{ $prestations->total() > 1 ? 's' : '' }}</p>

    {{-- Grille de cartes --}}
    @if ($prestations->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach ($prestations as $prestation)
                <div class="group bg-white rounded-[22px] shadow-ninich border border-ninich-line overflow-hidden hover:shadow-ninich-lg transition">
                    {{-- Image + badges --}}
                    <div class="relative h-56 bg-ninich-blush-2 flex items-center justify-center overflow-hidden">
                        @if ($prestation->image)
                            <img src="{{ $prestation->image }}" alt="{{ $prestation->nom }}"
                                 class="h-full w-full object-cover group-hover:scale-105 transition">
                        @else
                            <span class="text-5xl">💅</span>
                        @endif
                        @if ($prestation->avis_count > 0)
                            <span class="absolute top-3.5 right-3.5 bg-ninich-ink/80 text-white text-xs font-semibold px-3 py-1.5 rounded-full">★ {{ number_format(round($prestation->avis_avg_note, 1), 1, ',', ' ') }}</span>
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="font-serif text-2xl font-bold text-ninich-ink">{{ $prestation->nom }}</h2>

                        <p class="mt-2 text-sm text-ninich-muted line-clamp-2 min-h-[2.75rem]">{{ $prestation->description }}</p>

                        <div class="mt-4 flex items-center gap-4 text-[13px] text-ninich-muted">
                            <span class="inline-flex items-center gap-1.5">⏱ {{ $prestation->duree }} min</span>
                            <span class="inline-flex items-center gap-1.5">💬 {{ $prestation->avis_count > 0 ? $prestation->avis_count.' avis' : 'Pas encore d\'avis' }}</span>
                        </div>

                        <div class="mt-5 flex items-center justify-between border-t border-ninich-line pt-4">
                            <span class="font-serif text-2xl text-ninich-rose-dark">{{ number_format($prestation->prix, 2, ',', ' ') }} <small class="text-sm text-ninich-muted font-sans">€</small></span>
                            @auth
                                <a href="{{ route('reservations.create', $prestation) }}" wire:navigate
                                   class="rounded-full bg-ninich-rose px-6 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">
                                    Réserver
                                </a>
                            @else
                                <a href="{{ route('login') }}" wire:navigate
                                   class="rounded-full bg-ninich-ink px-6 py-2.5 text-sm text-white font-semibold hover:bg-ninich-rose-dark transition">
                                    Se connecter
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $prestations->links() }}
        </div>
    @else
        <div class="text-center py-20 text-ninich-muted">
            Aucune prestation trouvée.
        </div>
    @endif
</div>
