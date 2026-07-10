<div>
    @if ($reservation->estNotable())
        @if (! $showForm)
            <button wire:click="$set('showForm', true)"
                    class="rounded-lg bg-ninich-gold px-4 py-2 text-[13px] font-semibold text-white hover:opacity-90 transition">
                ★ Laisser un avis
            </button>
        @else
            <form wire:submit="enregistrer" class="mt-2 w-full rounded-2xl bg-ninich-blush p-4 ring-1 ring-ninich-line">
                {{-- Sélecteur d'étoiles --}}
                <div class="flex items-center gap-1" role="radiogroup" aria-label="Note">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('note', {{ $i }})"
                                aria-label="{{ $i }} étoile(s)"
                                class="text-2xl leading-none transition {{ $i <= $note ? 'text-ninich-gold' : 'text-ninich-line hover:text-ninich-gold/60' }}">
                            ★
                        </button>
                    @endfor
                    <span class="ml-2 text-sm text-ninich-muted">{{ $note }}/5</span>
                </div>
                @error('note') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <textarea wire:model="commentaire" rows="2"
                          placeholder="Votre commentaire (facultatif)…"
                          class="mt-3 w-full rounded-xl border-ninich-line bg-white text-sm shadow-sm focus:border-ninich-rose focus:ring-ninich-rose"></textarea>
                @error('commentaire') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <div class="mt-3 flex items-center gap-3">
                    <button type="submit"
                            class="rounded-full bg-ninich-rose px-5 py-2 text-sm font-semibold text-white hover:bg-ninich-rose-dark transition">
                        Envoyer
                    </button>
                    <button type="button" wire:click="$set('showForm', false)"
                            class="text-sm text-ninich-muted hover:underline">
                        Annuler
                    </button>
                </div>
            </form>
        @endif
    @elseif ($reservation->avis)
        {{-- Avis déjà déposé : rappel de la note donnée. --}}
        <div class="inline-flex items-center gap-1.5 rounded-full bg-ninich-blush-2 px-3 py-1 text-xs font-semibold text-ninich-gold">
            <span>{{ str_repeat('★', $reservation->avis->note) }}<span class="text-ninich-line">{{ str_repeat('★', 5 - $reservation->avis->note) }}</span></span>
            <span class="text-ninich-muted">Votre avis</span>
        </div>
    @endif
</div>
