@extends('boutique.layout')

@section('titre', 'Notre histoire — Blac Joyaux')

{{-- Mode pleine largeur, comme l'accueil éditorial --}}
@section('pleine_largeur') @endsection

@section('contenu')

{{-- CHAPITRE 0 — OUVERTURE --}}
<section class="chapter hero">
    {{-- SECTION MÉDIA : à remplir --}}
    {{-- Idée : photo de l'atelier, d'une artisane au travail, ou plan large de sacs alignés --}}
    {{-- <img class="hero-video" src="{{ asset('images/histoire/atelier.jpg') }}" alt=""> --}}
    <div class="hero-overlay"></div>
    <div class="hero-kicker">Notre histoire</div>
    <h1 class="hero-title">Blac Joyaux,<br><em>c'est…</em></h1>
    <div class="hero-scroll"><span>Découvrir</span><div class="line"></div></div>
</section>

{{-- CHAPITRE I — LE SAVOIR CRÉATIF --}}
<section class="chapter bloc-edito">
    <span class="folio left">I</span>
    <div class="inner">
        <div class="visual reveal">
            {{-- SECTION MÉDIA : à remplir --}}
            {{-- Idée : photo/vidéo courte d'une artisane en train de coudre ou tanner le cuir, région centrale de Côte d'Ivoire --}}
            <img src="{{ asset('images/capsule/saphir_noir4.jpeg') }}" alt="Savoir-faire Blac Joyaux">
            <div class="stamp">Un savoir créatif féminin</div>
        </div>
        <div class="txt">
            <div class="eyebrow reveal">L'origine</div>
            <h2 class="big reveal d1">Un savoir créatif<br><em>féminin</em>,<br>né au cœur du pays.</h2>
            <p class="body-txt reveal d2">Blac Joyaux, c'est un savoir créatif féminin de la région centrale de la Côte d'Ivoire, en Afrique.</p>
        </div>
    </div>
</section>

{{-- CHAPITRE II — LA MISSION --}}
<section class="chapter" style="flex-direction:column;justify-content:center;background:var(--encre-chaude);color:var(--ivoire);padding:14vh 40px;position:relative;overflow:hidden;">
    {{-- SECTION MÉDIA : à remplir (fond plein cadre en option) --}}
    {{-- Idée : vidéo en boucle de sacs finis, ou photo d'une vitrine du showroom Cocody Palmeraie --}}
    <video class="hero-video" src="{{ asset('videos/mission.mp4') }}" alt="" style="opacity:.25;" autoplay muted loop>
    </video>
    <div class="reveal" style="text-align:center;max-width:760px;margin:0 auto;position:relative;z-index:2;">
        <div class="eyebrow" style="color:var(--or-doux);">Notre mission</div>
        <h2 class="big" style="color:var(--ivoire);margin-bottom:24px;">Valoriser le savoir<br>créatif ivoirien</h2>
        <p class="body-txt" style="color:#cfc4b2;">Son but est de participer à la valorisation du savoir créatif en Côte d'Ivoire et au-delà, en proposant des sacs à main made in Côte d'Ivoire, accessibles et qui répondent aux besoins du marché actuel.</p>
    </div>
</section>

{{-- CHAPITRE III — L'INVITATION --}}
<section class="chapter closing">
    <span class="folio right">III</span>
    {{-- SECTION MÉDIA --}}
    <div class="visual reveal"><img src="{{ asset('images/capsule/kente3.jpeg') }}" alt=""></div>
    <div class="eyebrow reveal" style="color:var(--or-doux);">Au quotidien</div>
    <h2 class="big reveal d1">Adoptez Blac Joyaux,<br>donnez une <em>fière allure</em><br>à votre style.</h2>
    <a href="{{ route('boutique.catalogue') }}" class="btn-ghost reveal d2">Découvrir les sacs</a>
</section>

@endsection
