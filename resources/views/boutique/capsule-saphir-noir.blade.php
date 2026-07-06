@extends('boutique.layout')

@section('titre', 'Le Saphir Noir — Proposition capsule Blac Joyaux')
@section('meta_description', 'Le Saphir Noir : proposition de sac de bureau mixte en cuir graine noir, ornee de la poupee Ashanti. Concept capsule Blac Joyaux 2026.')

@section('contenu')

<div class="capsule-page">

    <div class="fil" style="margin-bottom: 16px;">
        <a href="{{ route('boutique.capsule') }}" style="color: var(--or);">Capsule</a> · Le Saphir Noir
    </div>

    <div class="capsule-page-grid">

        <div class="cp-galerie">
            <div class="cp-principale">
                <img id="cp-image" src="{{ asset('images/capsule/saphir_noir.jpeg') }}" alt="Le Saphir Noir — proposition Blac Joyaux">
            </div>
            <div class="cp-miniatures">
                <img src="{{ asset('images/capsule/saphir_noir.jpeg') }}" alt="Le Saphir Noir vue 1" onclick="document.getElementById('cp-image').src=this.src">
                {{-- Ajoute d'autres vues ici quand tu les auras :
                <img src="{{ asset('images/capsule/AUTRE.jpeg') }}" alt="vue 2" onclick="document.getElementById('cp-image').src=this.src">
                --}}
            </div>
        </div>

        <div class="cp-texte">
            <div class="fil">Modèle 01 · Capsule concept 2026</div>
            <h1>Le Saphir Noir</h1>

            @include('boutique.partials.capsule-note')

            {{-- ===== TEXTE À MODIFIER LIBREMENT ===== --}}
            <p>
                Incarnation parfaite du sac de bureau mixte et moderne, ce modèle allie la rigueur
                professionnelle et l'élégance intemporelle d'un cuir grainé noir profond aux détails
                graphiques d'inspiration africaine.
            </p>
            <p>
                Sa structure géométrique et épurée met en valeur l'élément culturel central de la marque :
                la poupée de fécondité Ashanti « Joyau de Bla », ici réinventée sous la forme d'un fermoir
                en laiton doré brossé d'un raffinement digne de la Haute Couture.
            </p>
            <p>
                Les bandes latérales ornées de motifs ethniques discrets apportent une touche chaleureuse,
                marquant le relief et la joie propres à l'ADN de la maison, pour un accessoire pensé comme
                ultra-fonctionnel, durable et statutaire.
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
