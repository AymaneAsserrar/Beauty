<div>
    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-serif text-3xl font-bold text-ninich-ink">Mon agenda</h2>
            <p class="text-sm text-ninich-muted mt-1">Retrouvez ici les rendez-vous qui vous sont attribués.</p>
        </div>
        <div class="inline-flex rounded-2xl bg-white border border-ninich-line p-1.5 text-sm shadow-ninich">
            <button wire:click="$set('vue','a_venir')"
                    class="rounded-xl px-6 py-2 font-semibold transition {{ $vue==='a_venir' ? 'bg-ninich-rose text-white' : 'text-ninich-muted' }}">À venir</button>
            <button wire:click="$set('vue','passes')"
                    class="rounded-xl px-6 py-2 font-semibold transition {{ $vue==='passes' ? 'bg-ninich-rose text-white' : 'text-ninich-muted' }}">Passés</button>
        </div>
    </div>

    @php
        $couleurs = [
            'en_attente' => 'bg-amber-100 text-amber-700',
            'confirmee'  => 'bg-sky-100 text-sky-700',
            'annulee'    => 'bg-red-100 text-red-700',
            'terminee'   => 'bg-green-100 text-green-700',
        ];
    @endphp

    <div class="bg-white rounded-[18px] border border-ninich-line shadow-ninich overflow-hidden">
        @forelse ($reservations as $r)
            <div class="flex items-center gap-5 p-5 {{ ! $loop->last ? 'border-b border-ninich-line' : '' }}">
                {{-- Bloc heure --}}
                <div class="w-16 text-center shrink-0">
                    <b class="font-serif text-xl text-ninich-rose-dark leading-none block">{{ $r->date_heure->format('H:i') }}</b>
                    <span class="text-[11px] text-ninich-muted">{{ $r->prestation->duree }} min</span>
                </div>

                <div class="w-12 h-12 rounded-full bg-ninich-blush-2 flex items-center justify-center text-lg shrink-0">👤</div>

                <div class="flex-1">
                    <b class="text-[15px] block text-ninich-ink">{{ $r->client->name }}</b>
                    <span class="text-[13px] text-ninich-muted">{{ $r->prestation->nom }} · {{ $r->date_heure->translatedFormat('D d M Y') }}</span>
                    @if ($r->notes)
                        <p class="text-xs text-ninich-muted mt-1 italic">« {{ $r->notes }} »</p>
                    @endif
                </div>

                <span class="rounded-full px-3 py-1 text-xs font-semibold whitespace-nowrap {{ $couleurs[$r->statut] ?? '' }}">● {{ $r->statutLabel() }}</span>

                <div class="flex items-center gap-2">
                    @if ($r->statut === 'en_attente')
                        <button wire:click="marquer({{ $r->id }}, 'confirmee')" class="rounded-lg bg-ninich-rose px-4 py-2 text-[13px] font-semibold text-white hover:bg-ninich-rose-dark transition">Confirmer</button>
                    @endif
                    @if (in_array($r->statut, ['en_attente','confirmee']) && $r->date_heure->isPast())
                        <button wire:click="marquer({{ $r->id }}, 'terminee')" class="rounded-lg bg-white px-4 py-2 text-[13px] font-semibold text-green-600 border-[1.5px] border-green-500 hover:bg-green-50 transition">Terminer</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-ninich-muted">Aucun rendez-vous {{ $vue==='a_venir' ? 'à venir' : 'passé' }}.</div>
        @endforelse
    </div>
</div>
