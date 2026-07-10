<div>
    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-200">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="font-serif text-2xl font-bold text-ninich-ink">Gestion des utilisateurs</h2>
        <div class="flex items-center gap-2">
            <select wire:model.live="filtreRole" class="rounded-xl border-ninich-line bg-white text-sm focus:border-ninich-rose focus:ring-ninich-rose">
                <option value="">Tous les rôles</option>
                <option value="admin">Admins</option>
                <option value="prestataire">Prestataires</option>
                <option value="client">Clients</option>
            </select>
            <button wire:click="nouveau" class="rounded-full bg-ninich-rose px-5 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">+ Ajouter</button>
        </div>
    </div>

    @if ($showForm)
        <form wire:submit="enregistrer" class="mb-6 bg-white rounded-[18px] border border-ninich-line p-6 shadow-ninich space-y-4">
            <h3 class="font-serif text-lg font-bold text-ninich-ink">{{ $editingId ? 'Modifier' : 'Nouvel' }} utilisateur</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Nom</label>
                    <input type="text" wire:model="name" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Rôle</label>
                    <select wire:model="role" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                        <option value="client">Client</option>
                        <option value="prestataire">Prestataire</option>
                        <option value="admin">Administrateur</option>
                    </select>
                    @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Téléphone</label>
                    <input type="text" wire:model="phone" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-ninich-ink mb-1">Bio / Spécialité (prestataire)</label>
                    <input type="text" wire:model="bio" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-ninich-ink mb-1">
                        Mot de passe {{ $editingId ? '(laisser vide pour ne pas changer)' : '' }}
                    </label>
                    <input type="password" wire:model="password" class="w-full rounded-xl border-ninich-line bg-ninich-blush focus:border-ninich-rose focus:ring-ninich-rose">
                    @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-full bg-ninich-rose px-6 py-2.5 text-sm text-white font-semibold hover:bg-ninich-rose-dark transition">Enregistrer</button>
                <button type="button" wire:click="$set('showForm', false)" class="rounded-full bg-ninich-blush-2 px-6 py-2.5 text-sm text-ninich-ink font-semibold hover:bg-ninich-line transition">Annuler</button>
            </div>
        </form>
    @endif

    <div class="bg-white rounded-[18px] border border-ninich-line shadow-ninich overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-ninich-blush text-left text-ninich-muted uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Nom</th>
                    <th class="px-5 py-3.5 font-semibold">Email</th>
                    <th class="px-5 py-3.5 font-semibold">Rôle</th>
                    <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                    <tr class="border-t border-ninich-line">
                        <td class="px-5 py-4 font-semibold text-ninich-ink">{{ $u->name }}</td>
                        <td class="px-5 py-4 text-ninich-muted">{{ $u->email }}</td>
                        <td class="px-5 py-4">
                            @php $rc = ['admin'=>'bg-purple-100 text-purple-700','prestataire'=>'bg-sky-100 text-sky-700','client'=>'bg-ninich-blush-2 text-ninich-muted']; @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $rc[$u->role] ?? '' }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td class="px-5 py-4 text-right space-x-3">
                            <button wire:click="editer({{ $u->id }})" class="font-semibold text-ninich-rose hover:underline">Modifier</button>
                            <button wire:click="supprimer({{ $u->id }})"
                                    wire:confirm="Supprimer cet utilisateur ?"
                                    class="font-semibold text-red-600 hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-ninich-muted">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
