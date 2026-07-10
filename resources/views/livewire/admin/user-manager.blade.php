<div>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 ring-1 ring-green-200">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-200">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Gestion des utilisateurs</h2>
        <div class="flex items-center gap-2">
            <select wire:model.live="filtreRole" class="rounded-lg border-gray-300 text-sm focus:border-pink-500 focus:ring-pink-500">
                <option value="">Tous les rôles</option>
                <option value="admin">Admins</option>
                <option value="prestataire">Prestataires</option>
                <option value="client">Clients</option>
            </select>
            <button wire:click="nouveau" class="rounded-full bg-pink-600 px-4 py-2 text-sm text-white font-medium hover:bg-pink-700">+ Ajouter</button>
        </div>
    </div>

    @if ($showForm)
        <form wire:submit="enregistrer" class="mb-6 bg-white rounded-xl ring-1 ring-gray-100 p-5 space-y-4">
            <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Modifier' : 'Nouvel' }} utilisateur</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select wire:model="role" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                        <option value="client">Client</option>
                        <option value="prestataire">Prestataire</option>
                        <option value="admin">Administrateur</option>
                    </select>
                    @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="text" wire:model="phone" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Bio / Spécialité (prestataire)</label>
                    <input type="text" wire:model="bio" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Mot de passe {{ $editingId ? '(laisser vide pour ne pas changer)' : '' }}
                    </label>
                    <input type="password" wire:model="password" class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                    @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-full bg-pink-600 px-5 py-2 text-sm text-white font-medium hover:bg-pink-700">Enregistrer</button>
                <button type="button" wire:click="$set('showForm', false)" class="rounded-full bg-gray-100 px-5 py-2 text-sm text-gray-700 hover:bg-gray-200">Annuler</button>
            </div>
        </form>
    @endif

    <div class="bg-white rounded-xl ring-1 ring-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Rôle</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($users as $u)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $u->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $u->email }}</td>
                        <td class="px-4 py-3">
                            @php $rc = ['admin'=>'bg-purple-100 text-purple-700','prestataire'=>'bg-blue-100 text-blue-700','client'=>'bg-gray-100 text-gray-600']; @endphp
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $rc[$u->role] ?? '' }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <button wire:click="editer({{ $u->id }})" class="text-pink-600 hover:underline">Modifier</button>
                            <button wire:click="supprimer({{ $u->id }})"
                                    wire:confirm="Supprimer cet utilisateur ?"
                                    class="text-red-600 hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
