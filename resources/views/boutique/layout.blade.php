<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Blac Joyaux — Maroquinerie ivoirienne')</title>
    <meta name="description" content="@yield('meta_description', 'Blac Joyaux, maison ivoirienne de maroquinerie. Des joyaux noirs qui se portent en héritage avec élégance. Sacs artisanaux made in Côte d\'Ivoire, livrés à Abidjan sous 1 à 3 jours.')">
    @yield('jsonld')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --noir: #141110; --noir-doux: #221D1A;
            --creme: #F7F3EC; --blanc-chaud: #FFFDF9;
            --or: #B98A2F; --or-clair: #D9B96A;
            --encre: #2B2622; --gris: #8A8178; --ligne: #E6DFD3;
            --vert-wa: #1FA855; --danger: #8E2323; --ok: #25402C;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Jost', sans-serif; background: var(--creme); color: var(--encre); font-size: 16px; line-height: 1.55; }
        h1, h2, h3, .serif { font-family: 'Cormorant Garamond', serif; font-weight: 600; }
        a { color: inherit; }
        img { display: block; max-width: 100%; }

        /* ---------- Header ---------- */
        .entete-site {
            background: var(--noir); color: #EDE6DA;
            position: sticky; top: 0; z-index: 50;
        }
        .entete-site .barre {
            max-width: 1100px; margin: 0 auto; padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 20px; letter-spacing: .32em; text-transform: uppercase; color: var(--or-clair); text-decoration: none; white-space: nowrap; }
        .nav-site { display: flex; gap: 22px; align-items: center; }
        .nav-site a { text-decoration: none; font-size: 14px; letter-spacing: .08em; color: #CFC7BA; }
        .nav-site a:hover, .nav-site a.actif { color: var(--or-clair); }
        .lien-panier { position: relative; }
        .lien-panier .compteur {
            position: absolute; top: -9px; right: -13px;
            background: var(--or); color: var(--noir);
            font-size: 11px; font-weight: 600; min-width: 18px; height: 18px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0 4px;
        }
        .bandeau-info {
            background: var(--or); color: var(--noir);
            text-align: center; font-size: 13px; letter-spacing: .06em; padding: 7px 16px;
        }

        /* ---------- Structure ---------- */
        .conteneur { max-width: 1100px; margin: 0 auto; padding: 32px 20px 64px; }
        .fil { font-size: 12px; letter-spacing: .2em; text-transform: uppercase; color: var(--or); margin-bottom: 6px; }
        .titre-page { font-size: clamp(30px, 5vw, 42px); margin-bottom: 24px; }

        /* ---------- Boutons ---------- */
        .btn { display: inline-block; padding: 13px 26px; font-family: 'Jost', sans-serif; font-size: 14px; letter-spacing: .1em; text-transform: uppercase; border: none; cursor: pointer; text-decoration: none; text-align: center; transition: all .15s; }
        .btn-noir { background: var(--noir); color: var(--or-clair); }
        .btn-noir:hover { background: var(--or); color: var(--noir); }
        .btn-ligne { background: transparent; color: var(--encre); border: 1px solid var(--encre); }
        .btn-ligne:hover { border-color: var(--or); color: var(--or); }
        .btn-whatsapp { background: var(--vert-wa); color: #fff; display: inline-flex; align-items: center; gap: 9px; justify-content: center; }
        .btn-whatsapp:hover { background: #17843F; }
        .btn-large { display: block; width: 100%; }

        /* ---------- Grille produits ---------- */
        .grille-produits { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 26px; }
        .carte-produit { text-decoration: none; }
        .carte-produit .visuel { aspect-ratio: 4/5; background: var(--blanc-chaud); border: 1px solid var(--ligne); overflow: hidden; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; color: var(--gris); font-size: 13px; }
        .carte-produit .visuel img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .carte-produit:hover .visuel img { transform: scale(1.04); }
        .carte-produit .collection { font-size: 11px; letter-spacing: .16em; text-transform: uppercase; color: var(--or); }
        .carte-produit .nom { font-family: 'Cormorant Garamond', serif; font-size: 20px; margin: 2px 0; }
        .carte-produit .prix { font-size: 15px; color: var(--encre); }

        /* ---------- Formulaires ---------- */
        label { display: block; font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris); margin-bottom: 7px; }
        input[type=text], input[type=tel], input[type=email], input[type=number], select, textarea {
            width: 100%; padding: 12px 14px; font-family: 'Jost', sans-serif; font-size: 15px; color: var(--encre);
            background: var(--blanc-chaud); border: 1px solid var(--ligne); outline: none;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--or); }
        .champ { margin-bottom: 18px; }
        .grille-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        @media (max-width: 640px) { .grille-2 { grid-template-columns: 1fr; } }

        .carte { background: var(--blanc-chaud); border: 1px solid var(--ligne); padding: 24px; margin-bottom: 22px; }
        .flash { padding: 13px 18px; margin-bottom: 22px; border-left: 3px solid var(--ok); background: #EEF2ED; color: var(--ok); }
        .erreurs { padding: 13px 18px; margin-bottom: 22px; border-left: 3px solid var(--danger); background: #F6ECEC; color: var(--danger); }
        .erreurs ul { margin-left: 18px; }

        /* ---------- Réassurance ---------- */
        .reassurance { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px; background: var(--ligne); border: 1px solid var(--ligne); margin: 36px 0; }
        .reassurance div { background: var(--blanc-chaud); padding: 20px; text-align: center; }
        .reassurance strong { display: block; font-family: 'Cormorant Garamond', serif; font-size: 19px; margin-bottom: 4px; }
        .reassurance span { font-size: 13.5px; color: var(--gris); }

        /* ---------- Footer ---------- */
        .pied { background: var(--noir); color: #CFC7BA; margin-top: 40px; }
        .pied .interieur { max-width: 1100px; margin: 0 auto; padding: 42px 20px; text-align: center; }
        .pied .slogan { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: var(--or-clair); margin-bottom: 8px; }
        .pied p { font-size: 13.5px; }
        .pied .filet { width: 44px; height: 1px; background: var(--or); margin: 18px auto; }

        .pagination { margin-top: 28px; display: flex; gap: 6px; justify-content: center; }
        .pagination a, .pagination span { padding: 8px 13px; border: 1px solid var(--ligne); text-decoration: none; font-size: 14px; background: var(--blanc-chaud); }
        .pagination .actif, .pagination a:hover { border-color: var(--or); color: var(--or); }

        @media (max-width: 640px) {
            .nav-site { gap: 14px; }
            .nav-site .masquer-mobile { display: none; }
        }
    </style>
</head>
<body>

<div class="bandeau-info">{{ config('boutique.delai_livraison') }} · Paiement Mobile Money ou à la livraison</div>

<header class="entete-site">
    <div class="barre">
        <a href="{{ route('boutique.accueil') }}" class="logo">Blac Joyaux</a>
        <nav class="nav-site">
            <a href="{{ route('boutique.catalogue') }}" class="{{ request()->routeIs('boutique.catalogue') ? 'actif' : '' }}">Les sacs</a>
            <a href="{{ route('boutique.catalogue', ['occasion' => 'Cadeau']) }}" class="masquer-mobile">Offrir</a>
            <a href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener" class="masquer-mobile">WhatsApp</a>
            <a href="{{ route('boutique.panier') }}" class="lien-panier {{ request()->routeIs('boutique.panier') ? 'actif' : '' }}">
                Panier
                @php $nb = app(\App\Services\Panier::class)->nombreArticles(); @endphp
                @if ($nb > 0)<span class="compteur">{{ $nb }}</span>@endif
            </a>
        </nav>
    </div>
</header>

<div class="conteneur">
    @if (session('succes'))
        <div class="flash">{{ session('succes') }}</div>
    @endif

    @if ($errors->any())
        <div class="erreurs">
            <ul>
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('contenu')
</div>

<footer class="pied">
    <div class="interieur">
        <div class="slogan">« L'avenir en main »</div>
        <div class="filet"></div>
        <p>Blac Joyaux — Maison ivoirienne de maroquinerie · Showroom Cocody Palmeraie, Abidjan</p>
        <p>Authentique made in CI · Durable · Accessible · Adaptable au style</p>
    </div>
</footer>

</body>
</html>
