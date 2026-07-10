<div>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Mon agenda</h2>
        <div class="inline-flex rounded-full bg-gray-100 p-1 text-sm">
            <button wire:click="$set('vue','a_venir')"
                    class="rounded-full px-4 py-1.5 {{ $vue==='a_venir' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">À venir</button>
            <button wire:click="$set('vue','passes')"
                    class="rounded-full px-4 py-1.5 {{ $vue==='passes' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">Passés</button>
        </div>
    </div>

    @forelse ($reservations as $r)
        <div class="mb-3 bg-white rounded-xl ring-1 ring-gray-100 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="font-semibold text-gray-900">{{ $r->prestation->nom }}</p>
                <p class="text-sm text-gray-500">
                    {{ $r->client->name }} · {{ $r->date_heure->format('d/m/Y à H:i') }} · {{ $r->prestation->duree }} min
                </p>
                @if ($r->notes)
                    <p class="text-xs text-gray-400 mt-1 italic">« {{ $r->notes }} »</p>
                @endif
            </div>

            <div class="flex items-center gap-3">
                @php
                    $couleurs = [
                        'en_attente' => 'bg-yellow-100 text-yellow-700',
                        'confirmee'  => 'bg-green-100 text-green-700',
                        'annulee'    => 'bg-red-100 text-red-700',
                        'terminee'   => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $couleurs[$r->statut] ?? '' }}">{{ $r->statutLabel() }}</span>

                @if ($r->statut === 'en_attente')
                    <button wire:click="marquer({{ $r->id }}, 'confirmee')" class="text-sm text-green-600 hover:underline">Confirmer</button>
                @endif
                @if (in_array($r->statut, ['en_attente','confirmee']) && $r->date_heure->isPast())
                    <button wire:click="marquer({{ $r->id }}, 'terminee')" class="text-sm text-gray-600 hover:underline">Terminer</button>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-gray-400">Aucun rendez-vous {{ $vue==='a_venir' ? 'à venir' : 'passé' }}.</div>
    @endforelse
</div>
