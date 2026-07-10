<div>
    @if ($reservation->estNotable())
        @if (! $showForm)
            <button wire:click="$set('showForm', true)"
                    class="text-sm font-medium text-pink-600 hover:underline">
                ★ Laisser un avis
            </button>
        @else
            <form wire:submit="enregistrer" class="mt-2 w-full rounded-lg bg-pink-50 p-4 ring-1 ring-pink-100">
                {{-- Sélecteur d'étoiles --}}
                <div class="flex items-center gap-1" role="radiogroup" aria-label="Note">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('note', {{ $i }})"
                                aria-label="{{ $i }} étoile(s)"
                                class="text-2xl leading-none transition {{ $i <= $note ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-300' }}">
                            ★
                        </button>
                    @endfor
                    <span class="ml-2 text-sm text-gray-500">{{ $note }}/5</span>
                </div>
                @error('note') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <textarea wire:model="commentaire" rows="2"
                          placeholder="Votre commentaire (facultatif)…"
                          class="mt-3 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500"></textarea>
                @error('commentaire') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <div class="mt-3 flex items-center gap-3">
                    <button type="submit"
                            class="rounded-full bg-pink-600 px-4 py-1.5 text-sm font-medium text-white hover:bg-pink-700">
                        Envoyer
                    </button>
                    <button type="button" wire:click="$set('showForm', false)"
                            class="text-sm text-gray-500 hover:underline">
                        Annuler
                    </button>
                </div>
            </form>
        @endif
    @elseif ($reservation->avis)
        {{-- Avis déjà déposé : rappel de la note donnée. --}}
        <div class="flex items-center gap-1 text-sm text-gray-500">
            <span class="text-yellow-400">
                {{ str_repeat('★', $reservation->avis->note) }}<span class="text-gray-300">{{ str_repeat('★', 5 - $reservation->avis->note) }}</span>
            </span>
            <span class="ml-1">Votre avis</span>
        </div>
    @endif
</div>
