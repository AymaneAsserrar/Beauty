<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- En-tête + recherche --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nos prestations</h1>
            <p class="mt-1 text-gray-500">Choisissez votre soin et réservez en quelques clics.</p>
        </div>
        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Rechercher une prestation..."
                   class="w-full rounded-full border-gray-300 pl-4 pr-10 py-2 shadow-sm focus:border-pink-500 focus:ring-pink-500">
            <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    {{-- Grille de cartes --}}
    @if ($prestations->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($prestations as $prestation)
                <div class="group bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden hover:shadow-lg transition">
                    {{-- Image --}}
                    <div class="h-44 bg-gradient-to-br from-pink-100 to-rose-200 flex items-center justify-center overflow-hidden">
                        @if ($prestation->image)
                            <img src="{{ $prestation->image }}" alt="{{ $prestation->nom }}"
                                 class="h-full w-full object-cover group-hover:scale-105 transition">
                        @else
                            <span class="text-5xl">💅</span>
                        @endif
                    </div>

                    <div class="p-5">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $prestation->nom }}</h2>

                        {{-- Note moyenne --}}
                        @if ($prestation->avis_count > 0)
                            @php $moyenne = round($prestation->avis_avg_note, 1); @endphp
                            <div class="mt-1 flex items-center gap-1 text-sm">
                                <span class="text-yellow-400">
                                    {{ str_repeat('★', (int) round($moyenne)) }}<span class="text-gray-300">{{ str_repeat('★', 5 - (int) round($moyenne)) }}</span>
                                </span>
                                <span class="font-medium text-gray-700">{{ number_format($moyenne, 1, ',', ' ') }}</span>
                                <span class="text-gray-400">({{ $prestation->avis_count }})</span>
                            </div>
                        @else
                            <div class="mt-1 text-sm text-gray-400">Pas encore d'avis</div>
                        @endif

                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $prestation->description }}</p>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="inline-flex items-center gap-1 text-gray-600">
                                ⏱ {{ $prestation->duree }} min
                            </span>
                            <span class="text-lg font-bold text-pink-600">{{ number_format($prestation->prix, 2, ',', ' ') }} €</span>
                        </div>

                        @auth
                            <a href="{{ route('reservations.create', $prestation) }}" wire:navigate
                               class="mt-4 block text-center rounded-full bg-pink-600 px-4 py-2 text-white font-medium hover:bg-pink-700 transition">
                                Réserver
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate
                               class="mt-4 block text-center rounded-full bg-gray-900 px-4 py-2 text-white font-medium hover:bg-gray-700 transition">
                                Se connecter pour réserver
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $prestations->links() }}
        </div>
    @else
        <div class="text-center py-20 text-gray-400">
            Aucune prestation trouvée.
        </div>
    @endif
</div>
