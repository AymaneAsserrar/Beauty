<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Polices --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

        {{-- Scripts (CSS + JS compilés par Vite) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ninich-ink antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-gradient-to-br from-ninich-blush-2 via-ninich-blush to-ninich-blush-2">

            {{-- Logo / marque --}}
            <a href="/" wire:navigate class="flex flex-col items-center mb-6">
                <span class="text-3xl">💅</span>
                <span class="mt-1 font-serif text-2xl font-bold text-ninich-ink">Ninich<span class="text-ninich-rose">Beauty</span></span>
            </a>

            {{-- Carte du formulaire --}}
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-ninich-lg ring-1 ring-ninich-line rounded-[22px]">
                {{ $slot }}
            </div>

            <p class="mt-6 text-sm text-ninich-muted">
                © {{ date('Y') }} Ninich Beauty — Réservez votre beauté en ligne.
            </p>
        </div>
    </body>
</html>
