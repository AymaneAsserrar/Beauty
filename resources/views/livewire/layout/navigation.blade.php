<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Déconnecte l'utilisateur puis le renvoie vers l'accueil.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-ninich-blush/90 backdrop-blur border-b border-ninich-line">
    {{-- Barre de navigation principale (bureau) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" wire:navigate class="font-serif text-2xl font-bold text-ninich-ink">
                        Ninich<span class="text-ninich-rose">Beauty</span>
                    </a>
                </div>

                {{-- Liens de navigation adaptés au rôle --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('prestations.index')" :active="request()->routeIs('prestations.index')" wire:navigate>
                        {{ __('Prestations') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Mon espace') }}
                        </x-nav-link>

                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.prestations')" :active="request()->routeIs('admin.prestations')" wire:navigate>Prestations (admin)</x-nav-link>
                            <x-nav-link :href="route('admin.reservations')" :active="request()->routeIs('admin.reservations')" wire:navigate>Réservations</x-nav-link>
                            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" wire:navigate>Utilisateurs</x-nav-link>
                        @elseif (auth()->user()->isPrestataire())
                            <x-nav-link :href="route('prestataire.agenda')" :active="request()->routeIs('prestataire.agenda')" wire:navigate>Mon agenda</x-nav-link>
                        @elseif (auth()->user()->isClient())
                            <x-nav-link :href="route('mes-reservations')" :active="request()->routeIs('mes-reservations')" wire:navigate>Mes réservations</x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Menu compte : connexion/inscription ou profil/déconnexion --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    <a href="{{ route('login') }}" wire:navigate class="text-sm font-medium text-ninich-muted hover:text-ninich-ink me-4">Connexion</a>
                    <a href="{{ route('register') }}" wire:navigate class="rounded-full bg-ninich-rose px-5 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">Inscription</a>
                @endguest

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            {{-- Bouton menu mobile --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu de navigation (mobile) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('prestations.index')" :active="request()->routeIs('prestations.index')" wire:navigate>
                {{ __('Prestations') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Mon espace') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        {{-- Options du compte (mobile) --}}
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
        @endauth
        @guest
        <div class="pt-4 pb-1 border-t border-gray-200 space-y-1">
            <x-responsive-nav-link :href="route('login')" wire:navigate>{{ __('Connexion') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" wire:navigate>{{ __('Inscription') }}</x-responsive-nav-link>
        </div>
        @endguest
    </div>
</nav>
