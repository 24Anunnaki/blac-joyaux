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
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,300;1,9..144,400&family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --noir: #141110; --noir-doux: #221D1A;
            --encre-chaude: #14110E;
            --creme: #F7F3EC; --blanc-chaud: #FFFDF9;
            --ivoire: #F4EFE6; --sable: #E4D9C5;
            --or: #B98A2F; --or-clair: #D9B96A; --or-doux: #D9BE7E;
            --encre: #2B2622; --terre: #8B6F47; --gris: #8A8178; --ligne: #E6DFD3;
            --vert-wa: #1FA855; --danger: #8E2323; --ok: #25402C;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Jost', sans-serif; background: var(--ivoire); color: var(--encre); font-size: 16px; line-height: 1.55; overflow-x: hidden; }
        h1, h2, h3, .serif { font-family: 'Fraunces', serif; font-weight: 400; }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ================= NAV ÉDITORIALE ================= */
        .bandeau-info { background: var(--encre-chaude); color: var(--or-doux); text-align: center; font-size: 12px; letter-spacing: .12em; padding: 9px 16px; text-transform: uppercase; }
        .entete-site { position: sticky; top: 0; z-index: 60; background: rgba(20,17,14,.92); backdrop-filter: blur(8px); color: #EDE6DA; }
        .entete-site .barre { max-width: 1300px; margin: 0 auto; padding: 18px 40px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .logo { font-family: 'Fraunces', serif; font-size: 22px; letter-spacing: .3em; text-transform: uppercase; color: var(--or-doux); white-space: nowrap; }
        .nav-site { display: flex; gap: 28px; align-items: center; }
        .nav-site a { font-size: 12px; letter-spacing: .12em; text-transform: uppercase; color: #CFC7BA; transition: color .2s; }
        .nav-site a:hover, .nav-site a.actif { color: var(--or-doux); }
        .lien-panier { position: relative; }
        .lien-panier .compteur { position: absolute; top: -9px; right: -13px; background: var(--or); color: var(--noir); font-size: 11px; font-weight: 600; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0 4px; }

        /* ================= MESSAGES ================= */
        .zone-messages { max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        .flash { padding: 13px 18px; margin: 22px 0 0; border-left: 3px solid var(--ok); background: #EEF2ED; color: var(--ok); }
        .erreurs { padding: 13px 18px; margin: 22px 0 0; border-left: 3px solid var(--danger); background: #F6ECEC; color: var(--danger); }
        .erreurs ul { margin-left: 18px; }

        /* ================= STRUCTURE STANDARD (pages intérieures) ================= */
        .conteneur { max-width: 1100px; margin: 0 auto; padding: 40px 20px 64px; }
        .fil { font-size: 12px; letter-spacing: .2em; text-transform: uppercase; color: var(--or); margin-bottom: 8px; }
        .titre-page { font-size: clamp(30px, 5vw, 46px); margin-bottom: 24px; font-weight: 300; }

        /* ================= BOUTONS ================= */
        .btn { display: inline-block; padding: 15px 34px; font-family: 'Jost', sans-serif; font-size: 12px; letter-spacing: .18em; text-transform: uppercase; border: none; cursor: pointer; text-align: center; transition: all .25s; }
        .btn-noir { background: var(--encre-chaude); color: var(--or-doux); }
        .btn-noir:hover { background: var(--terre); color: var(--ivoire); }
        .btn-ligne { background: transparent; color: var(--encre); border: 1px solid var(--encre); }
        .btn-ligne:hover { border-color: var(--or); color: var(--or); }
        .btn-ghost { display:inline-block; border:1px solid var(--or-doux); color:var(--or-doux); padding:16px 46px; font-size:12px; letter-spacing:.24em; text-transform:uppercase; transition:.3s; }
        .btn-ghost:hover { background:var(--or-doux); color:var(--encre-chaude); }
        .btn-whatsapp { background: var(--vert-wa); color: #fff; display: inline-flex; align-items: center; gap: 9px; justify-content: center; }
        .btn-whatsapp:hover { background: #17843F; }
        .btn-large { display: block; width: 100%; }

        /* ================= GRILLE PRODUITS ================= */
        .grille-produits { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 30px; }
        .carte-produit { display:block; }
        .carte-produit .visuel { aspect-ratio: 4/5; background: var(--blanc-chaud); border: 1px solid var(--ligne); overflow: hidden; margin-bottom: 14px; display: flex; align-items: center; justify-content: center; color: var(--gris); font-size: 13px; }
        .carte-produit .visuel img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.2,.7,.2,1); }
        .carte-produit:hover .visuel img { transform: scale(1.06); }
        .carte-produit .collection { font-size: 11px; letter-spacing: .16em; text-transform: uppercase; color: var(--or); }
        .carte-produit .nom { font-family: 'Fraunces', serif; font-size: 22px; margin: 3px 0; font-weight: 400; }
        .carte-produit .prix { font-size: 15px; color: var(--encre); }

        /* ================= FORMULAIRES ================= */
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

        /* ================= RÉASSURANCE ================= */
        .reassurance { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px; background: var(--ligne); border: 1px solid var(--ligne); margin: 36px 0; }
        .reassurance div { background: var(--blanc-chaud); padding: 24px; text-align: center; }
        .reassurance strong { display: block; font-family: 'Fraunces', serif; font-size: 20px; margin-bottom: 4px; font-weight: 400; }
        .reassurance span { font-size: 13.5px; color: var(--gris); }

        /* ================= PAGINATION ================= */
        .pagination { margin-top: 28px; display: flex; gap: 6px; justify-content: center; }
        .pagination a, .pagination span { padding: 8px 13px; border: 1px solid var(--ligne); font-size: 14px; background: var(--blanc-chaud); }
        .pagination .actif, .pagination a:hover { border-color: var(--or); color: var(--or); }

        /* ================= ÉLÉMENTS ÉDITORIAUX (accueil) ================= */
        .chapter { min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .chapter + .chapter { margin-top: 40px; }
        .folio { position: absolute; top: 50%; transform: translateY(-50%); font-family: 'Fraunces', serif; font-size: 22vw; line-height: .8; color: rgba(184,149,74,.08); z-index: 0; font-weight: 300; pointer-events: none; }
        .folio.left { left: -2vw; } .folio.right { right: -2vw; }

        .hero { background: radial-gradient(ellipse at 65% 45%,#2a2118,#14110E 70%); color: var(--ivoire); flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .hero-kicker { font-size: 12px; letter-spacing: .5em; text-transform: uppercase; color: var(--or-doux); margin-bottom: 28px; opacity: 0; animation: fadeUp 1s .2s forwards; z-index: 2; }
        .hero-title { font-family: 'Fraunces', serif; font-weight: 300; font-size: clamp(48px,9vw,130px); line-height: .95; opacity: 0; animation: fadeUp 1.1s .45s forwards; z-index: 2; }
        .hero-title em { font-style: italic; color: var(--or-doux); }
        .hero-sub { font-size: 15px; letter-spacing: .04em; color: #cfc4b2; margin-top: 26px; max-width: 420px; opacity: 0; animation: fadeUp 1s .8s forwards; z-index: 2; }
        .hero-scroll { position: absolute; bottom: 38px; left: 50%; transform: translateX(-50%); font-size: 11px; letter-spacing: .24em; text-transform: uppercase; color: #cfc4b2; opacity: 0; animation: fadeUp 1s 1.2s forwards; display: flex; flex-direction: column; align-items: center; gap: 10px; z-index: 2; }
        .hero-scroll .line { width: 1px; height: 40px; background: linear-gradient(var(--or-doux),transparent); }
        .hero-bag { position: absolute; font-size: min(46vh,420px); opacity: .16; filter: drop-shadow(0 30px 60px rgba(0,0,0,.5)); animation: float 6s ease-in-out infinite; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(30px);} to{opacity:1;transform:translateY(0);} }
        @keyframes float { 0%,100%{transform:translateY(0) rotate(-4deg);} 50%{transform:translateY(-24px) rotate(-4deg);} }

        .reveal { opacity: 0; transform: translateY(48px); transition: opacity 1s cubic-bezier(.2,.7,.2,1), transform 1s cubic-bezier(.2,.7,.2,1); }
        .reveal.in { opacity: 1; transform: none; }
        .reveal.d1 { transition-delay: .12s; } .reveal.d2 { transition-delay: .24s; } .reveal.d3 { transition-delay: .36s; }

        .bloc-edito { background: var(--ivoire); }
        .bloc-edito .inner { display: grid; grid-template-columns: 1fr 1fr; width: 100%; align-items: center; }
        .bloc-edito .visual { height: 100vh; background: linear-gradient(160deg,#2a2118,#14110E); display: flex; align-items: center; justify-content: center; position: relative; }
        .bloc-edito .visual .doll { font-size: 230px; filter: drop-shadow(0 20px 50px rgba(0,0,0,.5)); }
        .bloc-edito .visual .stamp { position: absolute; bottom: 44px; left: 44px; font-size: 11px; letter-spacing: .24em; text-transform: uppercase; color: var(--or-doux); }
        .bloc-edito .txt { padding: 0 8vw; }
        .eyebrow { font-size: 12px; letter-spacing: .3em; text-transform: uppercase; color: var(--or); margin-bottom: 22px; }
        .big { font-family: 'Fraunces', serif; font-weight: 300; font-size: clamp(32px,3.6vw,54px); line-height: 1.08; margin-bottom: 26px; }
        .big em { font-style: italic; color: var(--terre); }
        .body-txt { font-size: 15px; line-height: 1.95; color: #5c5346; max-width: 460px; margin-bottom: 32px; }
        .link-or { font-size: 12px; letter-spacing: .16em; text-transform: uppercase; border-bottom: 1px solid var(--or); padding-bottom: 5px; color: var(--encre); transition: .3s; display: inline-block; }
        .link-or:hover { color: var(--or); letter-spacing: .24em; }

        .closing { background: radial-gradient(ellipse at 50% 60%,#2a2118,#14110E); color: var(--ivoire); flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 0 24px; }
        .closing .big { color: var(--ivoire); max-width: 14ch; margin-inline: auto; }
        .closing .big em { color: var(--or-doux); }

/* ===== FOOTER ===== */
    footer{background:var(--encre);color:#8a8177;padding:70px 44px 40px;}
    .foot-top{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:30px;max-width:1300px;margin:0 auto 44px;}
    .foot-brand .fl{font-family:'Fraunces',serif;font-size:26px;letter-spacing:5px;color:var(--ivoire);margin-bottom:18px;}
    .foot-brand p{font-size:13px;line-height:1.9;max-width:280px;}
    .foot-col h4{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--ivoire);margin-bottom:18px;}
    .foot-col a{display:block;font-size:13px;margin-bottom:11px;transition:.2s;}
    .foot-col a:hover{color:var(--or-clair);}
    .foot-bottom{border-top:1px solid #2a241d;padding-top:24px;text-align:center;font-size:12px;letter-spacing:1px;max-width:1300px;margin:0 auto;}


/* ================= WHATSAPP FLOTTANT ================= */
        .wa-float { position: fixed; bottom: 28px; right: 28px; width: 56px; height: 56px; background: var(--vert-wa); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 6px 20px rgba(0,0,0,.3); z-index: 90; }

        @media (max-width: 820px) {
            .entete-site .barre { padding: 14px 20px; }
            .nav-site { gap: 16px; }
            .nav-site .masquer-mobile { display: none; }
            .bloc-edito .inner { grid-template-columns: 1fr; }
            .bloc-edito .visual { height: 60vh; }
            .bloc-edito .visual .doll { font-size: 150px; }
            .bloc-edito .txt { padding: 12vh 24px; }
        }

        .variantes { margin: 22px 0; }
        .variantes-label {
            font-size: 12px; letter-spacing: .12em; text-transform: uppercase;
            color: #8A8178; margin-bottom: 10px;
        }
        .variantes-pastilles { display: flex; gap: 10px; flex-wrap: wrap; }
        .pastille {
            width: 30px; height: 30px; border-radius: 50%;
            border: 2px solid transparent; cursor: pointer;
            display: inline-block; transition: transform .15s, border-color .15s;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,.08);
        }
        .pastille:hover { transform: scale(1.12); }
        .pastille.active {
            border-color: #B8954A;
            box-shadow: 0 0 0 2px rgba(184,149,74,.25);
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

{{-- Messages flash et erreurs (hors conteneur pour laisser l'accueil pleine largeur) --}}
@if (session('succes') || $errors->any())
<div class="zone-messages">
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
</div>
@endif

{{-- Le contenu : soit pleine largeur (accueil éditorial), soit dans un conteneur --}}
@hasSection('pleine_largeur')
    @yield('contenu')
@else
    <div class="conteneur">
        @yield('contenu')
    </div>
@endif

<footer class="pied">
    <div class="foot-top">
        <div class="foot-brand">
            <div class="fl">BLAC JOYAUX</div>
            <p>Des joyaux noirs qui se portent en héritage avec élégance. Maison ivoirienne de maroquinerie, Cocody Palmeraie, Abidjan.</p>
        </div>
        <div class="foot-col">
            <h4>Boutique</h4>
            <a href="{{ route('boutique.catalogue') }}">Tous les sacs</a>
            <a href="{{ route('boutique.catalogue', ['occasion' => 'Cadeau']) }}">Offrir</a>
            <a href="{{ route('boutique.panier') }}">Mon panier</a>
        </div>
        <div class="foot-col">
            <h4>La Maison</h4>
            <a href="#">Notre histoire</a>
            <a href="#">Savoir-faire</a>
            <a href="#">Le showroom</a>
        </div>
        <div class="foot-col">
            <h4>Aide</h4>
            <a href="{{ config('boutique.delai_livraison') ? '#' : '#' }}">Livraison</a>
            <a href="#">Paiement</a>
            <a href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
        <div class="foot-col">
            <h4>Le showroom</h4>
            <div class="foot-map">
                {{-- Colle ici l'iframe copié depuis Google Maps --}}
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.3430118488154!2d-3.9606418999999997!3d5.3645357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1edf921c30feb%3A0x26f35522969b004e!2sBlac%20joyaux%20I%20Maroquinerie%20Abidjan!5e0!3m2!1sfr!2sci!4v1783288638479!5m2!1sfr!2sci" width="80%" height="140" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <p style="font-size:12px;color:#9a948c;margin-top:8px;">Cocody Palmeraie, Abidjan</p>
        </div>
    </div>
    <div class="foot-bottom">
        <span>© 2026 Blac Joyaux. Tous droits réservés.</span>
        <span>Abidjan · Côte d'Ivoire</span>
    </div>

</footer>
<a href="https://wa.me/{{ config('boutique.whatsapp') }}" class="wa-float" target="_blank" rel="noopener">💬</a>

<script>
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); } });
    }, { threshold: .18 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>

</body>
</html>
