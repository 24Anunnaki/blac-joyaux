@extends('boutique.layout')

@section('titre', 'Tous les sacs — Blac Joyaux')
@section('meta_description', 'Découvrez tous les sacs à main Blac Joyaux : collection Joyau de Bla, Collection DO, sacs de bureau. Maroquinerie artisanale made in Côte d\'Ivoire, de 40 000 à 100 000 FCFA.')

@section('contenu')

<div class="fil">Catalogue</div>
<h1 class="titre-page">Les sacs</h1>

<div class="carte">
    <form method="GET" action="{{ route('boutique.catalogue') }}"
          style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px; align-items: end;">
        <div class="champ" style="margin: 0;">
            <label for="categorie">Collection</label>
            <select id="categorie" name="categorie" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ" style="margin: 0;">
            <label for="couleur">Couleur</label>
            <select id="couleur" name="couleur" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach ($couleurs as $couleur)
                    <option value="{{ $couleur->id }}" @selected(request('couleur') == $couleur->id)>{{ $couleur->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ" style="margin: 0;">
            <label for="matiere">Matière</label>
            <select id="matiere" name="matiere" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere }}" @selected(request('matiere') === $matiere)>{{ $matiere }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ" style="margin: 0;">
            <label for="occasion">Occasion</label>
            <select id="occasion" name="occasion" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach ($occasions as $occasion)
                    <option value="{{ $occasion }}" @selected(request('occasion') === $occasion)>{{ $occasion }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ" style="margin: 0;">
            <label for="prix_max">Budget max (FCFA)</label>
            <select id="prix_max" name="prix_max" onchange="this.form.submit()">
                <option value="">Sans limite</option>
                @foreach ([40000, 60000, 80000, 100000] as $seuil)
                    <option value="{{ $seuil }}" @selected(request('prix_max') == $seuil)>{{ number_format($seuil, 0, ',', ' ') }}</option>
                @endforeach
            </select>
        </div>
        @if (request()->hasAny(['categorie', 'couleur', 'matiere', 'occasion', 'prix_max']))
            <a href="{{ route('boutique.catalogue') }}" class="btn btn-ligne" style="padding: 11px 16px;">Tout effacer</a>
        @endif
    </form>
</div>

@if ($produits->isEmpty())
    <div class="carte" style="text-align: center; padding: 48px 24px;">
        <h2 style="margin-bottom: 8px;">Aucun sac ne correspond à ces critères</h2>
        <p style="color: var(--gris); margin-bottom: 18px;">Essayez d'élargir les filtres, ou demandez-nous directement : il arrive qu'un modèle soit disponible au showroom.</p>
        <a class="btn btn-whatsapp" href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener">Nous écrire sur WhatsApp</a>
    </div>
@else
    <div class="grille-produits">
        @foreach ($produits as $produit)
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

    <div class="pagination">{{ $produits->links('pagination::simple-default') }}</div>
@endif

@endsection
