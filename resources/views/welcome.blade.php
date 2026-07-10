<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninich Beauty — Réservez votre soin en ligne</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { margin: 0; background: #fffaf9; }
        * { box-sizing: border-box; }
        .nb-link { color: #b3186f; text-decoration: none; }
        .nb-link:hover { color: #8f1259; }

        .nb-page   { font-family: 'Work Sans', sans-serif; background: #fffaf9; color: #241419; min-height: 100vh; }
        .nb-nav    { position: relative; display: flex; align-items: center; justify-content: space-between; padding: 28px 64px; }
        .nb-brand  { font-family: 'Sora', sans-serif; font-weight: 800; font-size: 22px; letter-spacing: -0.02em; color: #b3186f; }
        .nb-navlinks { display: flex; align-items: center; gap: 28px; }
        .nb-navlink { font-size: 15px; font-weight: 500; color: #3a2a30; text-decoration: none; }
        .nb-navlink:hover { color: #b3186f; }
        .nb-btn-primary { background: #b3186f; color: #fff; padding: 11px 22px; border-radius: 999px; font-size: 14px; font-weight: 600; text-decoration: none; }
        .nb-btn-primary:hover { background: #8f1259; color: #fff; }

        .nb-hero   { position: relative; overflow: hidden; background: linear-gradient(155deg, #fff0f4 0%, #fef7f3 45%, #fffaf9 100%); }
        .nb-blob-1 { position: absolute; top: -180px; right: -160px; width: 520px; height: 520px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, oklch(0.88 0.07 350), oklch(0.94 0.03 350) 70%, transparent 100%); opacity: 0.7; }
        .nb-blob-2 { position: absolute; bottom: -220px; left: -140px; width: 420px; height: 420px; border-radius: 50%; background: radial-gradient(circle at 60% 40%, oklch(0.9 0.06 20), transparent 75%); opacity: 0.6; }

        .nb-hero-inner { position: relative; max-width: 860px; margin: 0 auto; text-align: center; padding: 70px 32px 96px; }
        .nb-badge  { display: inline-flex; align-items: center; gap: 8px; background: #ffffffb0; border: 1px solid #f4c9dc; padding: 7px 16px; border-radius: 999px; font-size: 13px; font-weight: 600; color: #b3186f; margin-bottom: 28px; }
        .nb-title  { font-family: 'Sora', sans-serif; font-size: 60px; line-height: 1.08; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 22px; color: #241419; }
        .nb-title span { color: #b3186f; }
        .nb-lead   { font-size: 18px; line-height: 1.6; color: #5c4a50; max-width: 560px; margin: 0 auto 36px; }
        .nb-cta-row { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .nb-cta-primary { background: #b3186f; color: #fff; padding: 16px 32px; border-radius: 999px; font-size: 16px; font-weight: 600; box-shadow: 0 12px 28px -8px #b3186f66; text-decoration: none; }
        .nb-cta-primary:hover { background: #8f1259; color: #fff; }
        .nb-cta-secondary { background: #ffffff; color: #3a2a30; border: 1px solid #ecdadf; padding: 16px 32px; border-radius: 999px; font-size: 16px; font-weight: 600; text-decoration: none; }
        .nb-cta-secondary:hover { border-color: #b3186f; color: #b3186f; }

        .nb-features { max-width: 1180px; margin: 0 auto; padding: 88px 32px 100px; }
        .nb-grid   { display: grid; grid-template-columns: repeat(3, 1fr); gap: 36px; }
        .nb-card   { display: flex; flex-direction: column; gap: 20px; }
        .nb-card-img { width: 100%; aspect-ratio: 4/3; border-radius: 20px; overflow: hidden; background: repeating-linear-gradient(135deg, #fbe4ec, #fbe4ec 10px, #f6d3e0 10px, #f6d3e0 20px); display: flex; align-items: center; justify-content: center; }
        .nb-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .nb-card-tag { font-family: monospace; font-size: 12px; color: #9a4f6b; background: #ffffffcc; padding: 4px 10px; border-radius: 6px; }
        .nb-card-title { font-family: 'Sora', sans-serif; font-size: 19px; font-weight: 700; margin: 0 0 8px; color: #241419; }
        .nb-card-text  { font-size: 15px; line-height: 1.55; color: #6b5a5f; margin: 0; }

        .nb-footer { border-top: 1px solid #f3e4e8; padding: 32px; text-align: center; }
        .nb-footer p { font-size: 13px; color: #9a8a8f; margin: 0; }

        @media (max-width: 860px) {
            .nb-nav { padding: 20px 24px; }
            .nb-navlinks { gap: 16px; }
            .nb-hero-inner { padding: 48px 24px 72px; }
            .nb-title { font-size: 40px; }
            .nb-lead { font-size: 16px; }
            .nb-features { padding: 56px 24px 72px; }
            .nb-grid { grid-template-columns: 1fr; gap: 28px; }
        }
    </style>
</head>
<body>

<div class="nb-page">

    {{-- Hero --}}
    <div class="nb-hero">
        <div class="nb-blob-1"></div>
        <div class="nb-blob-2"></div>

        <nav class="nb-nav">
            <div class="nb-brand">Ninich Beauty</div>
            <div class="nb-navlinks">
                <a href="{{ route('prestations.index') }}" class="nb-navlink">Prestations</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nb-btn-primary">Mon espace</a>
                @else
                    <a href="{{ route('login') }}" class="nb-navlink">Connexion</a>
                    <a href="{{ route('register') }}" class="nb-btn-primary">Inscription</a>
                @endauth
            </div>
        </nav>

        <div class="nb-hero-inner">
            <div class="nb-badge">
                Nouveau · Réservation en ligne 24h/24
            </div>
            <h1 class="nb-title">
                Votre beauté,<br><span>réservée en un clic</span>
            </h1>
            <p class="nb-lead">
                Fini la prise de rendez-vous par téléphone. Consultez nos prestations,
                choisissez votre créneau et réservez en ligne, où que vous soyez.
            </p>
            <div class="nb-cta-row">
                <a href="{{ route('prestations.index') }}" class="nb-cta-primary">Découvrir les prestations</a>
                @guest
                    <a href="{{ route('register') }}" class="nb-cta-secondary">Créer un compte</a>
                @endguest
            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="nb-features">
        <div class="nb-grid">

            <div class="nb-card">
                <div class="nb-card-img">
                    <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&q=80&auto=format&fit=crop"
                         alt="Manucure et nail art" loading="lazy">
                </div>
                <div>
                    <h3 class="nb-card-title">Des prestations variées</h3>
                    <p class="nb-card-text">Manucure, soins, coiffure... trouvez le soin qu'il vous faut.</p>
                </div>
            </div>

            <div class="nb-card">
                <div class="nb-card-img">
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&q=80&auto=format&fit=crop"
                         alt="Réservation en ligne" loading="lazy">
                </div>
                <div>
                    <h3 class="nb-card-title">Réservation instantanée</h3>
                    <p class="nb-card-text">Choisissez votre prestataire, votre date et votre heure.</p>
                </div>
            </div>

            <div class="nb-card">
                <div class="nb-card-img">
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&q=80&auto=format&fit=crop"
                         alt="Espace client détente" loading="lazy">
                </div>
                <div>
                    <h3 class="nb-card-title">Simple et flexible</h3>
                    <p class="nb-card-text">Gérez et annulez vos rendez-vous depuis votre espace.</p>
                </div>
            </div>

        </div>
    </div>

    <div class="nb-footer">
        <p>© {{ date('Y') }} Ninich Beauty. Tous droits réservés.</p>
    </div>

</div>

</body>
</html>
