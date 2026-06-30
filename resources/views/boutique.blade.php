@extends('layouts.app')

@section('title', 'Boutique — Blac Joyaux')

@section('content')

    <!-- BANNIERE -->
    <section class="page-banner">
        <div class="eyebrow">La Boutique</div>
        <h1>Tous nos sacs</h1>
        <p>Découvrez l'intégralité de nos collections, façonnées à la main à Abidjan.</p>
    </section>

    <!-- FILTRES -->

    <div class="filter-bar">
        <div class="filters">
            <div class="filter active">Tout</div>
            <div class="filter">Joyau de Bla</div>
            <div class="filter">Collection Bureau</div>
            <div class="filter">Collection DO</div>
            <div class="filter">Nouveautés</div>
        </div>
        <div class="bar-right">
            <div class="drop">
                <select>
                    <option>Taille</option>
                    <option>Mini</option>
                    <option>Moyen</option>
                    <option>Grand</option>
                </select>
            </div>
            <div class="drop">
                <select>
                    <option>Couleur</option>
                    <option>Noir</option>
                    <option>Doré</option>
                    <option>Rouge</option>
                    <option>Bleu</option>
                    <option>Rose</option>
                    <option>Vert</option>
                    <option>Croco / Python</option>
                </select>
            </div>
            <div class="drop">
                <select>
                    <option>Trier par</option>
                    <option>Nouveautés</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                </select>
            </div>
        </div>
    </div>
    <!-- GRILLE PRODUITS -->
    <section class="shop">
        <div class="count">8 produits</div>
        <div class="grid">
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👜</span><div class="prod-tag">Nouveau</div><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Joyau de Bla</div><div class="prod-name">Le Joyau Noir</div><div class="prod-price">65 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">💼</span><div class="prod-tag">Nouveau</div><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection Bureau</div><div class="prod-name">Sac Bureau Éban</div><div class="prod-price">85 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👛</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection DO</div><div class="prod-name">Le DO Terracotta</div><div class="prod-price">40 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👜</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Édition couleur</div><div class="prod-name">Le Joyau Bleu Roi</div><div class="prod-price">70 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👜</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Joyau de Bla</div><div class="prod-name">Le Joyau Violet</div><div class="prod-price">65 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👜</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Joyau de Bla</div><div class="prod-name">Le Joyau Croco Rouge</div><div class="prod-price">75 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">💼</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection Bureau</div><div class="prod-name">Sac Bureau Caramel</div><div class="prod-price">85 000 FCFA</div>
            </a>
            <a href="#" class="prod">
                <div class="prod-img"><span class="bag">👛</span><div class="prod-fav">♡</div></div>
                <div class="prod-cat">Collection DO</div><div class="prod-name">Le DO Python</div><div class="prod-price">45 000 FCFA</div>
            </a>
        </div>
    </section>

@endsection
