<div>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Toutes les réservations</h2>
        <select wire:model.live="statut" class="rounded-lg border-gray-300 text-sm focus:border-pink-500 focus:ring-pink-500">
            <option value="">Tous les statuts</option>
            <option value="en_attente">En attente</option>
            <option value="confirmee">Confirmée</option>
            <option value="annulee">Annulée</option>
            <option value="terminee">Terminée</option>
        </select>
    </div>

    <div class="bg-white rounded-xl ring-1 ring-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Prestation</th>
                    <th class="px-4 py-3">Prestataire</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($reservations as $r)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $r->client->name }}</div>
                            <div class="text-xs text-gray-400">{{ $r->client->email }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $r->prestation->nom }}</td>
                        <td class="px-4 py-3">{{ $r->prestataire->name }}</td>
                        <td class="px-4 py-3">{{ $r->date_heure->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <select wire:change="changerStatut({{ $r->id }}, $event.target.value)"
                                    class="rounded-lg border-gray-300 text-xs focus:border-pink-500 focus:ring-pink-500">
                                <option value="en_attente" @selected($r->statut==='en_attente')>En attente</option>
                                <option value="confirmee"  @selected($r->statut==='confirmee')>Confirmée</option>
                                <option value="annulee"    @selected($r->statut==='annulee')>Annulée</option>
                                <option value="terminee"   @selected($r->statut==='terminee')>Terminée</option>
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Aucune réservation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reservations->links() }}</div>
</div>
