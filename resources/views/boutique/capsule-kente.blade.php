@extends('boutique.layout')

@section('titre', 'Le Kente — Proposition capsule Blac Joyaux')
@section('meta_description', 'Le Kente : proposition de sac a bandouliere en cuir graine bordeaux, bandes brodees ethniques. Concept capsule Blac Joyaux 2026.')

@section('contenu')

<div class="capsule-page">

    <div class="fil" style="margin-bottom: 16px;">
        <a href="{{ route('boutique.capsule') }}" style="color: var(--or);">Capsule</a> · Le Kente
    </div>

    <div class="capsule-page-grid">

        <div class="cp-galerie">
            <div class="cp-principale">
                <img id="cp-image" src="{{ asset('images/capsule/kente.jpeg') }}" alt="Le Kente — proposition Blac Joyaux">
            </div>
            <div class="cp-miniatures">
                <img src="{{ asset('images/capsule/kente.jpeg') }}" alt="Le Kente vue 1" onclick="document.getElementById('cp-image').src=this.src">
                {{-- Ajoute d'autres vues ici quand tu les auras :
                <img src="{{ asset('images/capsule/AUTRE.jpeg') }}" alt="vue 2" onclick="document.getElementById('cp-image').src=this.src">
                --}}
            </div>
        </div>

        <div class="cp-texte">
            <div class="fil">Modèle 03 · Capsule concept 2026</div>
            <h1>Le Kente</h1>

            @include('boutique.partials.capsule-note')

            {{-- ===== TEXTE À MODIFIER LIBREMENT ===== --}}
            <p>
                Ce modèle à bandoulière incarne une vision pétillante du luxe accessible, jouant sur des
                couleurs chaudes et sombres en adéquation avec la direction artistique d'Aliwax.
            </p>
            <p>
                Sa robe de cuir grainé bordeaux s'associe à de magnifiques bandes brodées de motifs ethniques
                géométriques, apportant la richesse culturelle et la joie indispensables à l'identité de la
                maison. Rehaussé de soufflets latéraux texturés et d'un nœud de cuir artisanal, il met en
                scène la poupée « Joyau de Bla » par un précieux insigne en laiton doré brossé.
            </p>
            <p>
                Sa silhouette à rabat géométrique offre un équilibre entre héritage ivoirien et modernité
                citadine, comme accessoire de caractère pour les jeunes cadres qui veulent prendre l'avenir
                en main.
            </p>
            {{-- ===== FIN DU TEXTE ===== --}}

            <div class="cp-actions">
                <a href="{{ route('boutique.capsule') }}" class="btn btn-ligne">← Retour à la capsule</a>
                <a href="{{ route('boutique.catalogue') }}" class="btn btn-noir">Voir les modèles disponibles</a>
            </div>
        </div>
    </div>
</div>

@include('boutique.partials.capsule-styles')

@endsection
