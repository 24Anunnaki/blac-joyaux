@extends('boutique.layout')

@section('titre', 'Blac Joyaux — Des joyaux noirs qui se portent en héritage')

@section('contenu')

<section style="text-align: center; padding: 44px 0 36px;">
    <div class="fil">Maroquinerie ivoirienne</div>
    <h1 style="font-size: clamp(34px, 6vw, 54px); max-width: 720px; margin: 0 auto 14px;">
        Des joyaux noirs qui se portent en héritage avec élégance
    </h1>
    <p style="max-width: 520px; margin: 0 auto 26px; color: var(--gris);">
        Sacs artisanaux imaginés à Abidjan, inspirés de la poupée de fécondité ashanti.
        Faits main, faits pour durer, faits pour être offerts.
    </p>
    <a href="{{ route('boutique.catalogue') }}" class="btn btn-noir">Découvrir les sacs</a>
</section>

<div class="reassurance">
    <div><strong>Made in CI</strong><span>Fait main par nos artisans à Abidjan</span></div>
    <div><strong>1 à 3 jours</strong><span>Livraison rapide à Abidjan</span></div>
    <div><strong>Mobile Money</strong><span>Orange, MTN, Wave ou espèces</span></div>
    <div><strong>WhatsApp</strong><span>Une question ? Réponse rapide</span></div>
</div>

@if ($misEnAvant->isNotEmpty())
<section style="margin-top: 40px;">
    <div class="fil">La sélection</div>
    <h2 style="font-size: 30px; margin-bottom: 20px;">Nos joyaux du moment</h2>
    <div class="grille-produits">
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
                <div class="nom">{{ $produit->nom }}</div>
                <div class="prix">{{ $produit->prixFormate() }}</div>
            </a>
        @endforeach
    </div>
</section>
@endif

<section style="margin-top: 52px; text-align: center; background: var(--noir); color: #EDE6DA; padding: 44px 24px;">
    <div class="fil">L'idée cadeau parfaite</div>
    <h2 style="font-size: 28px; color: var(--or-clair); margin-bottom: 10px;">Un sac Blac Joyaux, ça s'offre</h2>
    <p style="max-width: 480px; margin: 0 auto 22px; color: #CFC7BA;">
        Emballage cadeau élégant et petit mot personnalisé offerts.
        Faites livrer directement chez la personne qui compte.
    </p>
    <a href="{{ route('boutique.catalogue', ['occasion' => 'Cadeau']) }}" class="btn" style="background: var(--or); color: var(--noir);">Voir les sacs à offrir</a>
</section>

@endsection
