<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Polices --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Scripts (CSS + JS compilés par Vite) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-gradient-to-br from-rose-50 via-white to-pink-100">

            {{-- Logo / marque --}}
            <a href="/" wire:navigate class="flex flex-col items-center mb-6">
                <span class="text-3xl">💅</span>
                <span class="mt-1 text-2xl font-bold text-pink-600">Ninich Beauty</span>
            </a>

            {{-- Carte du formulaire --}}
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl ring-1 ring-pink-100 rounded-2xl">
                {{ $slot }}
            </div>

            <p class="mt-6 text-sm text-gray-400">
                © {{ date('Y') }} Ninich Beauty — Réservez votre beauté en ligne.
            </p>
        </div>
    </body>
</html>
