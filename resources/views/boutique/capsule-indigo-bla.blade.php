@extends('boutique.layout')

@section('titre', 'L\'Indigo de Bla — Proposition capsule Blac Joyaux')
@section('meta_description', 'L\'Indigo de Bla : proposition de sac besace masculin en cuir bleu nuit, motifs Aliwax. Concept capsule Blac Joyaux 2026.')

@section('contenu')

<div class="capsule-page">

    <div class="fil" style="margin-bottom: 16px;">
        <a href="{{ route('boutique.capsule') }}" style="color: var(--or);">Capsule</a> · L'Indigo de Bla
    </div>

    <div class="capsule-page-grid">

        <div class="cp-galerie">
            <div class="cp-principale">
                <img id="cp-image" src="{{ asset('images/capsule/indigo_bla.jpeg') }}" alt="L'Indigo de Bla — proposition Blac Joyaux">
            </div>
            <div class="cp-miniatures">
                <img src="{{ asset('images/capsule/indigo_bla.jpeg') }}" alt="L'Indigo de Bla vue 1" onclick="document.getElementById('cp-image').src=this.src">
                {{-- Ajoute d'autres vues ici quand tu les auras :
                <img src="{{ asset('images/capsule/AUTRE.jpeg') }}" alt="vue 2" onclick="document.getElementById('cp-image').src=this.src">
                --}}
            </div>
        </div>

        <div class="cp-texte">
            <div class="fil">Modèle 02 · Capsule concept 2026</div>
            <h1>L'Indigo de Bla</h1>

            @include('boutique.partials.capsule-note')

            {{-- ===== TEXTE À MODIFIER LIBREMENT ===== --}}
            <p>
                Déclinaison mixte et résolument masculine imaginée pour la collection, ce sac besace compact
                réinvente la sacoche de bureau traditionnelle pour s'adapter au rythme de la vie moderne.
            </p>
            <p>
                Sa structure rectangulaire en cuir bleu nuit profond intègre une profondeur chromatique
                d'inspiration Aliwax, contrastant avec les bandes latérales texturées aux motifs géométriques
                dorés. Porté en bandoulière, le modèle met à l'honneur la poupée Ashanti « Joyau de Bla »,
                coulée dans un laiton vieilli minimaliste qui signe le positionnement haut de gamme et artisanal.
            </p>
            <p>
                Un accessoire de caractère, pensé pour le quotidien des professionnels ambitieux qui souhaitent
                concilier élégance, praticité et affirmation de leur identité culturelle.
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
