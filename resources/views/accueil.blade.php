@extends('layouts.app')

@section('title', 'Blac Joyaux — Maroquinerie ivoirienne')

@section('content')

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bag">👜</div>
        <div class="hero-eyebrow">Nouvelle capsule · 2026</div>
        <h1 class="hero-title">L'avenir en main</h1>
        <p class="hero-sub">La Collection Bureau, héritage ashanti et élégance contemporaine, façonnée à Abidjan.</p>
        <a href="{{ url('/boutique') }}" class="hero-btn">Découvrir la capsule</a>
    </section>

    <!-- COLLECTIONS -->
    <section class="sec">
        <div class="sec-head">
            <div class="sec-eyebrow">Explorer</div>
            <h2 class="sec-title">Nos collections</h2>
        </div>
        <div class="cats">
            <a href="{{ url('/boutique') }}" class="cat">
                <div class="cat-bg cat-c1">👜</div>
                <div class="cat-overlay">
                    <div class="cat-name">Joyau de Bla</div>
                    <span class="cat-link">Découvrir</span>
                </div>
            </a>
            <a href="{{ url('/boutique') }}" class="cat">
                <div class="cat-bg cat-c2">💼</div>
                <div class="cat-overlay">
                    <div class="cat-name">Collection Bureau</div>
                    <span class="cat-link">Découvrir</span>
                </div>
            </a>
            <a href="{{ url('/boutique') }}" class="cat">
                <div class="cat-bg cat-c3">👛</div>
                <div class="cat-overlay">
                    <div class="cat-name">Collection DO</div>
                    <span class="cat-link">Découvrir</span>
                </div>
            </a>
        </div>
    </section>

    <!-- PIECES PHARES -->
    <section class="sec" style="padding-top:0;">
        <div class="sec-head">
            <div class="sec-eyebrow">Sélection</div>
            <h2 class="sec-title">Nos pièces phares</h2>
        </div>
        <div class="prods">
            <a href="#" class="prod">
                <div class="prod-img"><span>👜</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Joyau de Bla</div>
                <div class="prod-name">Le Joyau Noir</div>
                <div class="prod-price">65 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span>💼</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection Bureau</div>
                <div class="prod-name">Sac Bureau Éban</div>
                <div class="prod-price">85 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span>👛</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection DO</div>
                <div class="prod-name">Le DO Terracotta</div>
                <div class="prod-price">40 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span>👜</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Édition couleur</div>
                <div class="prod-name">Le Joyau Bleu Roi</div>
                <div class="prod-price">70 000 FCFA</div>
            </a>
        </div>
    </section>

    <!-- EDITORIAL LA MAISON -->
    <section class="edito">
        <div class="edito-img">✦</div>
        <div class="edito-txt">
            <div class="edito-eyebrow">La Maison</div>
            <h2 class="edito-title">Un héritage<br>façonné à la main</h2>
            <p class="edito-sub">Chaque Joyau de Bla naît dans un atelier d'Adjamé, inspiré de la poupée de fécondité ashanti. Un savoir-faire ivoirien, des finitions d'exception, une élégance qui se transmet.</p>
            <a href="#" class="edito-btn">Notre histoire</a>
        </div>
    </section>

    <!-- REASSURANCE -->
    <section class="trust">
        <div class="trust-item"><div class="ti-ic">🚚</div><div class="ti-t">Livraison rapide</div><div class="ti-s">1 à 3 jours à Abidjan</div></div>
        <div class="trust-item"><div class="ti-ic">📱</div><div class="ti-t">Mobile Money</div><div class="ti-s">Paiement simple &amp; sécurisé</div></div>
        <div class="trust-item"><div class="ti-ic">💬</div><div class="ti-t">Conseil WhatsApp</div><div class="ti-s">Une question ? Écrivez-nous</div></div>
        <div class="trust-item"><div class="ti-ic">✦</div><div class="ti-t">Made in CI</div><div class="ti-s">Artisanat ivoirien authentique</div></div>
    </section>

@endsection
