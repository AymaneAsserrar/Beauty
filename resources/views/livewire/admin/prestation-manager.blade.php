<div>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Gestion des prestations</h2>
        <button wire:click="nouvelle"
                class="rounded-full bg-pink-600 px-4 py-2 text-sm text-white font-medium hover:bg-pink-700">
            + Ajouter une prestation
        </button>
    </div>

    {{-- Formulaire création / édition --}}
    @if ($showForm)
        <form wire:submit="enregistrer" class="mb-6 bg-white rounded-xl ring-1 ring-gray-100 p-5 space-y-4">
            <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Modifier' : 'Nouvelle' }} prestation</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" wire:model="nom" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('nom') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image (URL, facultatif)</label>
                    <input type="text" wire:model="image" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prix (€)</label>
                    <input type="number" step="0.01" wire:model="prix" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('prix') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Durée (minutes)</label>
                    <input type="number" wire:model="duree" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('duree') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" rows="2" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"></textarea>
                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" wire:model="active" class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                Visible dans le catalogue
            </label>

            <div class="flex gap-2">
                <button type="submit" class="rounded-full bg-pink-600 px-5 py-2 text-sm text-white font-medium hover:bg-pink-700">
                    Enregistrer
                </button>
                <button type="button" wire:click="$set('showForm', false)" class="rounded-full bg-gray-100 px-5 py-2 text-sm text-gray-700 hover:bg-gray-200">
                    Annuler
                </button>
            </div>
        </form>
    @endif

    {{-- Tableau --}}
    <div class="bg-white rounded-xl ring-1 ring-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Prix</th>
                    <th class="px-4 py-3">Durée</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($prestations as $p)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $p->nom }}</td>
                        <td class="px-4 py-3">{{ number_format($p->prix, 2, ',', ' ') }} €</td>
                        <td class="px-4 py-3">{{ $p->duree }} min</td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleActive({{ $p->id }})"
                                    class="rounded-full px-2 py-1 text-xs font-medium {{ $p->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $p->active ? 'Active' : 'Masquée' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <button wire:click="editer({{ $p->id }})" class="text-pink-600 hover:underline">Modifier</button>
                            <button wire:click="supprimer({{ $p->id }})"
                                    wire:confirm="Supprimer définitivement cette prestation ?"
                                    class="text-red-600 hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Aucune prestation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestations->links() }}</div>
</div>
