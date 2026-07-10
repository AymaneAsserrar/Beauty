<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninich Beauty — Réservez votre soin en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    <header class="absolute inset-x-0 top-0 z-10">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-5">
            <span class="text-xl font-bold text-pink-600">Ninich Beauty</span>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('prestations.index') }}" class="text-gray-700 hover:text-pink-600">Prestations</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-pink-600 px-4 py-2 text-white font-medium hover:bg-pink-700">Mon espace</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600">Connexion</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-pink-600 px-4 py-2 text-white font-medium hover:bg-pink-700">Inscription</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="relative isolate overflow-hidden bg-gradient-to-br from-rose-50 via-white to-pink-100">
            <div class="max-w-7xl mx-auto px-6 py-40 text-center">
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-gray-900">
                    Votre beauté, <span class="text-pink-600">réservée en un clic</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600">
                    Fini la prise de rendez-vous par téléphone. Consultez nos prestations,
                    choisissez votre créneau et réservez en ligne, 24h/24.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4">
                    <a href="{{ route('prestations.index') }}"
                       class="rounded-full bg-pink-600 px-8 py-3 text-white font-semibold hover:bg-pink-700 transition">
                        Découvrir les prestations
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="text-gray-700 font-medium hover:text-pink-600">Créer un compte →</a>
                    @endguest
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl">💅</div>
                <h3 class="mt-3 font-semibold text-lg">Des prestations variées</h3>
                <p class="mt-1 text-gray-500 text-sm">Manucure, soins, coiffure… trouvez le soin qu'il vous faut.</p>
            </div>
            <div>
                <div class="text-4xl">📅</div>
                <h3 class="mt-3 font-semibold text-lg">Réservation instantanée</h3>
                <p class="mt-1 text-gray-500 text-sm">Choisissez votre prestataire, votre date et votre heure.</p>
            </div>
            <div>
                <div class="text-4xl">✨</div>
                <h3 class="mt-3 font-semibold text-lg">Simple et flexible</h3>
                <p class="mt-1 text-gray-500 text-sm">Gérez et annulez vos rendez-vous depuis votre espace.</p>
            </div>
        </section>
    </main>

    <footer class="border-t border-gray-100 py-8 text-center text-sm text-gray-400">
        © {{ date('Y') }} Ninich Beauty. Tous droits réservés.
    </footer>
</body>
</html>
