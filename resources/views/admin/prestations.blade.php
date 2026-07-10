<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-bold text-ninich-ink">Administration · Prestations</h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <livewire:admin.prestation-manager />
    </div>
</x-app-layout>

{{--
    Pourquoi Laravel :
    1. Sa structure MVC claire.
    2. Rapidité de développement, framework moderne et accessible.
    3. Interaction avec la base de données via Eloquent (ORM).
--}}
