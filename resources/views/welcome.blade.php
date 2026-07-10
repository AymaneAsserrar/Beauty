<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninich Beauty — Réservez votre soin en ligne</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-ninich-ink bg-ninich-blush antialiased">

    {{-- NAV --}}
    <nav class="bg-ninich-blush/90 backdrop-blur border-b border-ninich-line">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between h-20">
            <div class="font-serif text-2xl font-bold">Ninich<span class="text-ninich-rose">Beauty</span></div>
            <div class="hidden md:flex items-center gap-9 text-[15px] font-medium text-ninich-muted">
                <a href="{{ route('welcome') }}" class="text-ninich-ink font-semibold">Accueil</a>
                <a href="{{ route('prestations.index') }}" class="hover:text-ninich-ink">Prestations</a>
                <a href="#etapes" class="hover:text-ninich-ink">Comment ça marche</a>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="rounded-full bg-ninich-rose px-6 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">Mon
                        espace</a>
                @else
                    <a href="{{ route('login') }}" class="text-[15px] font-semibold hover:text-ninich-rose">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="rounded-full bg-ninich-rose px-6 py-2.5 text-sm text-white font-semibold shadow-lg shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header class="max-w-7xl mx-auto px-6 lg:px-10 py-16 lg:py-20">
        <div class="flex flex-col lg:flex-row items-center gap-14">
            <div class="flex-1">
                <span
                    class="inline-block bg-ninich-blush-2 text-ninich-rose-dark font-semibold text-xs tracking-[0.15em] uppercase px-5 py-2 rounded-full mb-6">Institut
                    de beauté · Réservation en ligne</span>
                <h1 class="font-serif text-5xl lg:text-6xl font-bold leading-[1.1] mb-6">Révélez votre <em
                        class="italic text-ninich-rose">éclat</em> naturel en quelques clics</h1>
                <p class="text-lg text-ninich-muted leading-relaxed max-w-md mb-9">Découvrez notre catalogue de soins et
                    réservez votre rendez-vous avec nos expertes, en toute simplicité et à l'heure qui vous convient.
                </p>
                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="{{ route('prestations.index') }}"
                        class="inline-flex items-center justify-center rounded-full bg-ninich-rose px-8 py-4 text-white font-semibold shadow-xl shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">Découvrir
                        les prestations</a>
                    <a href="#etapes"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-transparent border-[1.5px] border-ninich-line px-8 py-4 font-semibold hover:border-ninich-rose transition">▶
                        Comment ça marche</a>
                </div>
                <div class="flex gap-11">
                    <div><b class="font-serif text-3xl text-ninich-rose-dark block">6+</b><span
                            class="text-[13px] text-ninich-muted">Prestations</span></div>
                    <div><b class="font-serif text-3xl text-ninich-rose-dark block">2</b><span
                            class="text-[13px] text-ninich-muted">Expertes certifiées</span></div>
                    <div><b class="font-serif text-3xl text-ninich-rose-dark block">4.9★</b><span
                            class="text-[13px] text-ninich-muted">Note moyenne</span></div>
                </div>
            </div>
            <div class="flex-1 relative w-full">
                <img class="rounded-[28px] shadow-ninich-lg h-[520px] w-full object-cover"
                    src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800&q=80&auto=format&fit=crop"
                    alt="Salon de beauté">
                <div
                    class="absolute left-2 -bottom-5 lg:-left-6 lg:bottom-10 bg-white rounded-2xl px-5 py-4 shadow-ninich-lg flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-ninich-blush-2 flex items-center justify-center text-xl">💆‍♀️
                    </div>
                    <div><b class="text-[15px] block">Prochain créneau</b><span
                            class="text-xs text-ninich-muted">Aujourd'hui · 14h30 disponible</span></div>
                </div>
            </div>
        </div>
    </header>

    {{-- SERVICES --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
        <div class="text-center max-w-xl mx-auto mb-14">
            <span
                class="inline-block bg-ninich-blush-2 text-ninich-rose-dark font-semibold text-xs tracking-[0.15em] uppercase px-5 py-2 rounded-full mb-4">Nos
                soins</span>
            <h2 class="font-serif text-4xl font-bold mb-3">Des prestations pensées pour vous</h2>
            <p class="text-ninich-muted">Manucure, soins du visage, maquillage… choisissez le soin qui vous ressemble.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
            @php
                $vitrine = [
                    [
                        't' => 'Ongles',
                        'n' => 'Manucure gel',
                        'd' => 'Pose de vernis semi-permanent longue tenue pour des mains impeccables.',
                        'p' => '250',
                        'du' => '60',
                        'img' => 'photo-1604654894610-df63bc536371',
                    ],
                    [
                        't' => 'Visage',
                        'n' => 'Soin du visage',
                        'd' => 'Nettoyage, gommage et masque hydratant pour une peau éclatante.',
                        'p' => '350',
                        'du' => '75',
                        'img' => 'photo-1570172619644-dfd03ed5d881',
                    ],
                    [
                        't' => 'Maquillage',
                        'n' => 'Maquillage soirée',
                        'd' => 'Maquillage professionnel sublimant pour tous vos événements.',
                        'p' => '300',
                        'du' => '45',
                        'img' => 'photo-1487412720507-e7ab37603c6f',
                    ],
                ];
            @endphp
            @foreach ($vitrine as $s)
                <div class="bg-white rounded-[22px] overflow-hidden shadow-ninich border border-ninich-line">
                    <img class="h-52 w-full object-cover"
                        src="https://images.unsplash.com/{{ $s['img'] }}?w=800&q=80&auto=format&fit=crop"
                        alt="{{ $s['n'] }}">
                    <div class="p-6">
                        <span
                            class="text-xs text-ninich-gold font-semibold tracking-wider uppercase">{{ $s['t'] }}</span>
                        <h3 class="font-serif text-2xl font-bold my-2">{{ $s['n'] }}</h3>
                        <p class="text-sm text-ninich-muted leading-relaxed mb-5">{{ $s['d'] }}</p>
                        <div class="flex items-center justify-between border-t border-ninich-line pt-4">
                            <span class="font-serif text-2xl text-ninich-rose-dark">{{ $s['p'] }} <small
                                    class="text-[13px] text-ninich-muted font-sans">€</small></span>
                            <span class="text-[13px] text-ninich-muted">⏱ {{ $s['du'] }} min</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('prestations.index') }}"
                class="inline-flex items-center justify-center rounded-full bg-ninich-rose px-8 py-4 text-white font-semibold shadow-xl shadow-ninich-rose/30 hover:bg-ninich-rose-dark transition">Voir
                tout le catalogue</a>
        </div>
    </section>

    {{-- STEPS --}}
    <section id="etapes" class="bg-ninich-blush-2 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center max-w-xl mx-auto mb-14">
                <span
                    class="inline-block bg-white text-ninich-rose-dark font-semibold text-xs tracking-[0.15em] uppercase px-5 py-2 rounded-full mb-4">Simple
                    &amp; rapide</span>
                <h2 class="font-serif text-4xl font-bold">Réservez en 3 étapes</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center px-3">
                    <div
                        class="w-16 h-16 rounded-full bg-white text-ninich-rose font-serif text-2xl font-bold flex items-center justify-center mx-auto mb-5 shadow-ninich-lg">
                        1</div>
                    <h3 class="font-serif text-xl font-bold mb-2">Choisissez un soin</h3>
                    <p class="text-sm text-ninich-muted leading-relaxed">Parcourez le catalogue et sélectionnez la
                        prestation qui vous convient.</p>
                </div>
                <div class="text-center px-3">
                    <div
                        class="w-16 h-16 rounded-full bg-white text-ninich-rose font-serif text-2xl font-bold flex items-center justify-center mx-auto mb-5 shadow-ninich-lg">
                        2</div>
                    <h3 class="font-serif text-xl font-bold mb-2">Sélectionnez un créneau</h3>
                    <p class="text-sm text-ninich-muted leading-relaxed">Choisissez votre experte, la date et l'horaire
                        disponible.</p>
                </div>
                <div class="text-center px-3">
                    <div
                        class="w-16 h-16 rounded-full bg-white text-ninich-rose font-serif text-2xl font-bold flex items-center justify-center mx-auto mb-5 shadow-ninich-lg">
                        3</div>
                    <h3 class="font-serif text-xl font-bold mb-2">Confirmez</h3>
                    <p class="text-sm text-ninich-muted leading-relaxed">Validez votre rendez-vous et recevez votre
                        confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
        <div
            class="rounded-[32px] bg-gradient-to-br from-ninich-rose to-ninich-rose-dark px-8 lg:px-16 py-16 text-center text-white">
            <h2 class="font-serif text-4xl font-bold mb-4">Prête à prendre soin de vous ?</h2>
            <p class="opacity-90 text-lg mb-8 max-w-lg mx-auto">Créez votre compte gratuitement et réservez votre
                premier rendez-vous dès aujourd'hui.</p>
            @auth
                <a href="{{ route('prestations.index') }}"
                    class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-ninich-rose-dark font-semibold hover:bg-ninich-blush transition">Réserver
                    maintenant</a>
            @else
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-ninich-rose-dark font-semibold hover:bg-ninich-blush transition">Créer
                    un compte</a>
            @endauth
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-ninich-ink text-ninich-line pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-10">
                <div class="col-span-2 md:col-span-1">
                    <div class="font-serif text-2xl text-white mb-3">Ninich Beauty</div>
                    <p class="text-[#C6ADA9] text-sm leading-relaxed">Institut de beauté &amp; plateforme de
                        réservation en ligne. Prenez soin de vous, où que vous soyez.</p>
                </div>
                <div>
                    <h4 class="font-serif text-white mb-4">Navigation</h4>
                    <a href="{{ route('welcome') }}"
                        class="block text-[#C6ADA9] text-sm mb-2.5 hover:text-white">Accueil</a>
                    <a href="{{ route('prestations.index') }}"
                        class="block text-[#C6ADA9] text-sm mb-2.5 hover:text-white">Prestations</a>
                </div>
                <div>
                    <h4 class="font-serif text-white mb-4">Compte</h4>
                    <a href="{{ route('login') }}"
                        class="block text-[#C6ADA9] text-sm mb-2.5 hover:text-white">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="block text-[#C6ADA9] text-sm mb-2.5 hover:text-white">Inscription</a>
                </div>
                <div>
                    <h4 class="font-serif text-white mb-4">Contact</h4>
                    <p class="text-[#C6ADA9] text-sm mb-2.5">Paris, France</p>
                    <p class="text-[#C6ADA9] text-sm mb-2.5">contact@ninich.test</p>
                </div>
            </div>
            <div class="border-t border-white/10 pt-6 text-center text-[#9C8480] text-[13px]">© {{ date('Y') }}
                Ninich Beauty — Tous droits réservés.</div>
        </div>
    </footer>

</body>

</html>
