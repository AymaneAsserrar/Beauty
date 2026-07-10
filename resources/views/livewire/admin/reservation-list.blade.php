<div>
    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="font-serif text-2xl font-bold text-ninich-ink">Toutes les réservations</h2>
        <select wire:model.live="statut" class="rounded-xl border-ninich-line bg-white text-sm focus:border-ninich-rose focus:ring-ninich-rose">
            <option value="">Tous les statuts</option>
            <option value="en_attente">En attente</option>
            <option value="confirmee">Confirmée</option>
            <option value="annulee">Annulée</option>
            <option value="terminee">Terminée</option>
        </select>
    </div>

    <div class="bg-white rounded-[18px] border border-ninich-line shadow-ninich overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-ninich-blush text-left text-ninich-muted uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Client</th>
                    <th class="px-5 py-3.5 font-semibold">Prestation</th>
                    <th class="px-5 py-3.5 font-semibold">Prestataire</th>
                    <th class="px-5 py-3.5 font-semibold">Date</th>
                    <th class="px-5 py-3.5 font-semibold">Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $r)
                    <tr class="border-t border-ninich-line">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-ninich-ink">{{ $r->client->name }}</div>
                            <div class="text-xs text-ninich-muted">{{ $r->client->email }}</div>
                        </td>
                        <td class="px-5 py-4 text-ninich-muted">{{ $r->prestation->nom }}</td>
                        <td class="px-5 py-4 text-ninich-muted">{{ $r->prestataire->name }}</td>
                        <td class="px-5 py-4 text-ninich-muted">{{ $r->date_heure->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-4">
                            <select wire:change="changerStatut({{ $r->id }}, $event.target.value)"
                                    class="rounded-lg border-ninich-line bg-white text-xs focus:border-ninich-rose focus:ring-ninich-rose">
                                <option value="en_attente" @selected($r->statut==='en_attente')>En attente</option>
                                <option value="confirmee"  @selected($r->statut==='confirmee')>Confirmée</option>
                                <option value="annulee"    @selected($r->statut==='annulee')>Annulée</option>
                                <option value="terminee"   @selected($r->statut==='terminee')>Terminée</option>
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-ninich-muted">Aucune réservation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reservations->links() }}</div>
</div>
