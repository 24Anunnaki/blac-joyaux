<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blac Joyaux')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- BARRE D'ANNONCE -->
    <div class="topbar">
        Livraison <span class="or">1 à 3 jours</span> à Abidjan · Paiement Mobile Money &amp; espèces · <span class="or">Made in Côte d'Ivoire</span>
    </div>

    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <a href="{{ url('/boutique') }}">Boutique</a>
            <a href="{{ url('/boutique') }}">Collections</a>
        </div>
        <a href="{{ url('/') }}" class="logo">BLAC JOYAUX</a>
        <div class="header-right">
            <a href="#" class="icon">🔍</a>
            <a href="#" class="icon">♡</a>
            <a href="#" class="icon">🛍</a>
        </div>
    </header>

    <!-- NAVIGATION -->
    <nav class="nav">
        <a href="{{ url('/boutique') }}">Nouveautés</a>
        <a href="{{ url('/boutique') }}">Joyau de Bla</a>
        <a href="{{ url('/boutique') }}">Collection Bureau</a>
        <a href="{{ url('/boutique') }}">Collection DO</a>
        <a href="#">La Maison</a>
    </nav>

    <!-- CONTENU DE CHAQUE PAGE -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="fb-logo">BLAC JOYAUX</div>
                <p>Des joyaux noirs qui se portent en héritage avec élégance. Maison ivoirienne de maroquinerie, Cocody Palmeraie, Abidjan.</p>
            </div>
            <div class="footer-col">
                <h4>Boutique</h4>
                <a href="{{ url('/boutique') }}">Joyau de Bla</a>
                <a href="{{ url('/boutique') }}">Collection Bureau</a>
                <a href="{{ url('/boutique') }}">Collection DO</a>
                <a href="{{ url('/boutique') }}">Nouveautés</a>
            </div>
            <div class="footer-col">
                <h4>La Maison</h4>
                <a href="#">Notre histoire</a>
                <a href="#">Savoir-faire</a>
                <a href="#">Le showroom</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-col">
                <h4>Aide</h4>
                <a href="#">Livraison</a>
                <a href="#">Paiement</a>
                <a href="#">FAQ</a>
                <a href="https://wa.me/2250700000000" target="_blank">WhatsApp</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 Blac Joyaux. Tous droits réservés.</span>
            <span>Abidjan · Côte d'Ivoire</span>
        </div>
    </footer>

    <!-- BOUTON WHATSAPP -->
    <a href="https://wa.me/+2250708771557" class="wa" target="_blank">💬</a>

</body>
</html>
