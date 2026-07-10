<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('prestations.index') }}" wire:navigate class="text-sm text-pink-600 hover:underline">&larr; Retour au catalogue</a>

    {{-- Récapitulatif prestation --}}
    <div class="mt-4 bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $prestation->nom }}</h1>
            <p class="text-gray-500 mt-1">{{ $prestation->description }}</p>
            <p class="text-sm text-gray-600 mt-2">⏱ {{ $prestation->duree }} min</p>
        </div>
        <span class="text-2xl font-bold text-pink-600">{{ number_format($prestation->prix, 2, ',', ' ') }} €</span>
    </div>

    <form wire:submit="reserver" class="mt-6 bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 space-y-6">

        {{-- 1. Prestataire --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">1. Choisissez votre prestataire</label>
            <select wire:model.live="prestataire_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                <option value="">-- Sélectionner --</option>
                @foreach ($this->prestataires as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} @if($p->bio) — {{ $p->bio }} @endif</option>
                @endforeach
            </select>
            @error('prestataire_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 2. Date --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">2. Choisissez une date</label>
            <input type="date" wire:model.live="date" min="{{ now()->format('Y-m-d') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            @error('date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 3. Créneaux horaires --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">3. Choisissez un créneau</label>

            @if (! $prestataire_id || ! $date)
                <p class="text-sm text-gray-400">Sélectionnez d'abord un prestataire et une date.</p>
            @elseif (count($this->creneaux) === 0)
                <p class="text-sm text-gray-400">Aucun créneau disponible ce jour-là.</p>
            @else
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                    @foreach ($this->creneaux as $creneau)
                        <button type="button"
                                wire:click="selectHeure('{{ $creneau['heure'] }}')"
                                @disabled(! $creneau['disponible'])
                                class="rounded-lg px-3 py-2 text-sm font-medium border transition
                                    @if($heure === $creneau['heure']) bg-pink-600 text-white border-pink-600
                                    @elseif($creneau['disponible']) bg-white text-gray-700 border-gray-300 hover:border-pink-500
                                    @else bg-gray-100 text-gray-300 border-gray-100 cursor-not-allowed line-through @endif">
                            {{ $creneau['heure'] }}
                        </button>
                    @endforeach
                </div>
            @endif
            @error('heure') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 4. Notes --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remarque (facultatif)</label>
            <textarea wire:model="notes" rows="2"
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                      placeholder="Une précision pour le prestataire ?"></textarea>
            @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Bouton --}}
        <button type="submit"
                class="w-full rounded-full bg-pink-600 px-6 py-3 text-white font-semibold hover:bg-pink-700 transition disabled:opacity-50"
                wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="reserver">Confirmer la réservation</span>
            <span wire:loading wire:target="reserver">Enregistrement...</span>
        </button>
    </form>
</div>
