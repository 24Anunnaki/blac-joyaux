@extends('boutique.layout')

@section('titre', 'Blac Joyaux — Des joyaux noirs qui se portent en héritage')

{{-- Active le mode pleine largeur du layout (accueil éditorial sans conteneur) --}}
@section('pleine_largeur') @endsection

@section('contenu')

{{-- CHAPITRE 0 — HERO --}}
<section class="chapter hero">
    <div class="hero-overlay"></div>
    <div class="hero-bag">👜</div>
    <div class="hero-kicker">Maison ivoirienne · depuis 2024</div>
    <h1 class="hero-title">L'avenir<br><em>en main</em></h1>
    <p class="hero-sub">Des joyaux noirs qui se portent en héritage avec élégance. Façonnés à la main, à Abidjan.</p>
    <div class="hero-scroll"><span>Découvrir</span><div class="line"></div></div>
</section>
{{-- CHAPITRE I — HÉRITAGE --}}
<section class="chapter bloc-edito">
    <span class="folio left">I</span>
    <div class="inner">
        <div class="visual reveal">
            <div class="doll">🪆</div>
            <div class="stamp">La poupée Joyau de Bla</div>
        </div>
        <div class="txt">
            <div class="eyebrow reveal">L'origine</div>
            <h2 class="big reveal d1">Un symbole<br>de <em>fécondité</em>,<br>devenu signature.</h2>
            <p class="body-txt reveal d2">Chaque sac naît dans un atelier d'Adjamé, où un artisan façonne le cuir à la main. Au cœur de la maison, la poupée de fécondité ashanti — le Joyau de Bla — veille comme un emblème d'héritage et de transmission.</p>
            <a href="{{ route('boutique.catalogue') }}" class="link-or reveal d3">Découvrir les sacs</a>
        </div>
    </div>
</section>

{{-- CHAPITRE II — LA SÉLECTION (vraies données) --}}
@if ($misEnAvant->isNotEmpty())
<section class="chapter" style="flex-direction:column;justify-content:center;background:var(--encre-chaude);color:var(--ivoire);padding:14vh 40px;">
    <div class="reveal" style="text-align:center;margin-bottom:8vh;">
        <div class="eyebrow" style="color:var(--or-doux);">La sélection</div>
        <h2 class="big" style="color:var(--ivoire);">Nos joyaux du moment</h2>
    </div>
    <div class="grille-produits reveal d1" style="max-width:1300px;margin:0 auto;width:100%;">
        @foreach ($misEnAvant as $produit)
            <a class="carte-produit" href="{{ route('boutique.produit', $produit->slug) }}">
                <div class="visuel">
                    @if ($produit->imagePrincipale)
                        <img src="{{ $produit->imagePrincipale->lien() }}" alt="Sac {{ $produit->nom }} — Blac Joyaux">
                    @else
                        Photo à venir
                    @endif
                </div>
                <div class="collection">{{ $produit->categorie->nom }}</div>
                <div class="nom" style="color:var(--ivoire);">{{ $produit->nom }}</div>
                <div class="prix" style="color:var(--or-doux);">{{ $produit->prixFormate() }}</div>
            </a>
        @endforeach
    </div>
    <div class="reveal d2" style="text-align:center;margin-top:6vh;">
        <a href="{{ route('boutique.catalogue') }}" class="btn-ghost">Voir toute la collection</a>
    </div>
</section>
@endif


@endsection
