@extends('boutique.layout')

@section('titre', 'La Capsule concept 2026 — Blac Joyaux')
@section('meta_description', 'Découvrez la capsule concept Blac Joyaux 2026 : Le Saphir Noir, L\'Indigo de Bla et Le Kente. Trois propositions de modèles qui réinventent la poupée Ashanti Joyau de Bla.')

@section('contenu')

{{-- BANNIÈRE --}}
<section style="text-align: center; padding: 40px 20px 30px;">
    <div class="fil">Proposition créative · 2026</div>
    <h1 style="font-size: clamp(34px, 6vw, 60px); font-weight: 300; line-height: 1.05;">
        La Capsule <em style="font-style: italic; color: var(--or);">Bureau</em>
    </h1>
    <p style="max-width: 600px; margin: 20px auto 0; font-size: 16px; line-height: 1.8; color: var(--gris);">
        Trois modèles imaginés dans le cadre de notre projet pour la maison Blac Joyaux. Chacun réinvente
        la poupée de fécondité Ashanti, emblème de la marque, entre héritage ivoirien et modernité citadine.
    </p>
</section>

{{-- Note "proposition" --}}
<div style="max-width: 760px; margin: 0 auto 20px; padding: 0 20px;">
    @include('boutique.partials.capsule-note')
</div>

{{-- LES 3 MODÈLES --}}
<section style="max-width: 1100px; margin: 0 auto; padding: 20px 20px 40px;">
    <div class="capsule-liste">

        <a href="{{ route('boutique.capsule.saphir') }}" class="capsule-carte">
            <div class="cc-img"><img src="{{ asset('images/capsule/saphir_noir1.jpeg') }}" alt="Le Saphir Noir"></div>
            <div class="cc-num">Modèle 01</div>
            <div class="cc-nom">Le Saphir Noir</div>
            <div class="cc-desc">Sac de bureau mixte en cuir grainé noir, fermoir poupée doré.</div>
            <span class="cc-lien">Découvrir ce modèle →</span>
        </a>

        <a href="{{ route('boutique.capsule.indigo') }}" class="capsule-carte">
            <div class="cc-img"><img src="{{ asset('images/capsule/indigo_bla1.jpeg') }}" alt="L'Indigo de Bla"></div>
            <div class="cc-num">Modèle 02</div>
            <div class="cc-nom">L'Indigo de Bla</div>
            <div class="cc-desc">Besace masculine en cuir bleu nuit, motifs Aliwax dorés.</div>
            <span class="cc-lien">Découvrir ce modèle →</span>
        </a>

        <a href="{{ route('boutique.capsule.kente') }}" class="capsule-carte">
            <div class="cc-img"><img src="{{ asset('images/capsule/kente1.jpeg') }}" alt="Le Kente"></div>
            <div class="cc-num">Modèle 03</div>
            <div class="cc-nom">Le Kente</div>
            <div class="cc-desc">Sac à bandoulière bordeaux, bandes brodées ethniques.</div>
            <span class="cc-lien">Découvrir ce modèle →</span>
        </a>

    </div>
</section>

{{-- RETOUR BOUTIQUE --}}
<section style="text-align: center; padding: 20px 20px 30px;">
    <a href="{{ route('boutique.catalogue') }}" class="btn btn-noir">Voir les modèles disponibles</a>
</section>

<style>
    .capsule-liste { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
    .capsule-carte { display: block; }
    .cc-img { aspect-ratio: 16/10; overflow: hidden; border-radius: 4px; margin-bottom: 16px; box-shadow: 0 14px 40px rgba(0,0,0,.1); }
    .cc-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.2,.7,.2,1); }
    .capsule-carte:hover .cc-img img { transform: scale(1.06); }
    .cc-num { font-family: 'Fraunces', serif; font-size: 12px; color: var(--or); letter-spacing: .1em; margin-bottom: 4px; }
    .cc-nom { font-family: 'Fraunces', serif; font-size: 24px; font-weight: 300; margin-bottom: 6px; }
    .cc-desc { font-size: 13.5px; color: var(--gris); line-height: 1.6; margin-bottom: 10px; }
    .cc-lien { font-size: 12px; letter-spacing: .1em; text-transform: uppercase; color: var(--encre); border-bottom: 1px solid var(--or); padding-bottom: 3px; }
    @media (max-width: 780px) {
        .capsule-liste { grid-template-columns: 1fr; gap: 40px; }
        .cc-img { aspect-ratio: 16/11; }
    }
</style>

@endsection
