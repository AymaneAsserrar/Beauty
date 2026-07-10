<div>
    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="font-serif text-2xl font-bold text-ninich-ink">Gestion des prestations</h2>
        <button wire:click="nouvelle"
                class="rounded-full bg-ninich-rose px-5 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">
            + Ajouter une prestation
        </button>
    </div>

    {{-- Formulaire création / édition --}}
    @if ($showForm)
        <form wire:submit="enregistrer" class="mb-6 bg-white rounded-[18px] border border-ninich-line p-6 shadow-ninich space-y-4">
            <h3 class="font-serif text-lg font-bold text-ninich-ink">{{ $editingId ? 'Modifier' : 'Nouvelle' }} prestation</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Nom</label>
                    <input type="text" wire:model="nom" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('nom') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Image (URL, facultatif)</label>
                    <input type="text" wire:model="image" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Prix (€)</label>
                    <input type="number" step="0.01" wire:model="prix" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('prix') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Durée (minutes)</label>
                    <input type="number" wire:model="duree" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('duree') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ninich-ink mb-1">Description</label>
                <textarea wire:model="description" rows="2" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose"></textarea>
                @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-ninich-ink">
                <input type="checkbox" wire:model="active" class="rounded border-ninich-line text-ninich-rose focus:ring-ninich-rose">
                Visible dans le catalogue
            </label>

            <div class="flex gap-2">
                <button type="submit" class="rounded-full bg-ninich-rose px-6 py-2.5 text-sm text-white font-semibold hover:bg-ninich-rose-dark transition">
                    Enregistrer
                </button>
                <button type="button" wire:click="$set('showForm', false)" class="rounded-full bg-ninich-blush-2 px-6 py-2.5 text-sm text-ninich-ink font-semibold hover:bg-ninich-line transition">
                    Annuler
                </button>
            </div>
        </form>
    @endif

    {{-- Tableau --}}
    <div class="bg-white rounded-[18px] border border-ninich-line shadow-ninich overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-ninich-blush text-left text-ninich-muted uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Nom</th>
                    <th class="px-5 py-3.5 font-semibold">Prix</th>
                    <th class="px-5 py-3.5 font-semibold">Durée</th>
                    <th class="px-5 py-3.5 font-semibold">Statut</th>
                    <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prestations as $p)
                    <tr class="border-t border-ninich-line">
                        <td class="px-5 py-4 font-semibold text-ninich-ink">{{ $p->nom }}</td>
                        <td class="px-5 py-4 text-ninich-muted">{{ number_format($p->prix, 2, ',', ' ') }} €</td>
                        <td class="px-5 py-4 text-ninich-muted">{{ $p->duree }} min</td>
                        <td class="px-5 py-4">
                            <button wire:click="toggleActive({{ $p->id }})"
                                    class="rounded-full px-3 py-1 text-xs font-semibold {{ $p->active ? 'bg-green-100 text-green-700' : 'bg-ninich-blush-2 text-ninich-muted' }}">
                                {{ $p->active ? 'Active' : 'Masquée' }}
                            </button>
                        </td>
                        <td class="px-5 py-4 text-right space-x-3">
                            <button wire:click="editer({{ $p->id }})" class="font-semibold text-ninich-rose hover:underline">Modifier</button>
                            <button wire:click="supprimer({{ $p->id }})"
                                    wire:confirm="Supprimer définitivement cette prestation ?"
                                    class="font-semibold text-red-600 hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-ninich-muted">Aucune prestation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestations->links() }}</div>
</div>
