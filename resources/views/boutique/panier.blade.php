@extends('boutique.layout')

@section('titre', 'Mon panier — Blac Joyaux')

@section('contenu')

<div class="fil">Votre sélection</div>
<h1 class="titre-page">Mon panier</h1>

@if (empty($lignes))
    <div class="carte" style="text-align: center; padding: 48px 24px;">
        <h2 style="margin-bottom: 8px;">Votre panier est vide</h2>
        <p style="color: var(--gris); margin-bottom: 18px;">Les joyaux vous attendent.</p>
        <a href="{{ route('boutique.catalogue') }}" class="btn btn-noir">Découvrir les sacs</a>
    </div>
@else
    <div class="carte" style="padding: 0;">
        @foreach ($lignes as $cle => $ligne)
            <div style="display: flex; gap: 16px; padding: 18px 20px; border-bottom: 1px solid var(--ligne); align-items: center; flex-wrap: wrap;">
                <div style="width: 76px; height: 76px; background: var(--creme); border: 1px solid var(--ligne); flex-shrink: 0; overflow: hidden;">
                    @if ($ligne['produit']->imagePrincipale)
                        <img src="{{ $ligne['produit']->imagePrincipale->lien() }}" alt="{{ $ligne['produit']->nom }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <a href="{{ route('boutique.produit', $ligne['produit']->slug) }}" style="text-decoration: none;">
                        <strong class="serif" style="font-size: 19px;">{{ $ligne['produit']->nom }}</strong>
                    </a>
                    @if ($ligne['couleur'])
                        <div style="font-size: 13.5px; color: var(--gris);">Couleur : {{ $ligne['couleur'] }}</div>
                    @endif
                    <div style="font-size: 14px;">{{ $ligne['produit']->prixFormate() }}</div>
                </div>
                <form method="POST" action="{{ route('boutique.panier.modifier', $cle) }}" style="display: flex; align-items: center; gap: 8px;">
                    @csrf
                    @method('PATCH')
                    <label for="q-{{ $loop->index }}" style="margin: 0;">Qté</label>
                    <input id="q-{{ $loop->index }}" type="number" name="quantite" value="{{ $ligne['quantite'] }}" min="0" max="10"
                           style="width: 70px;" onchange="this.form.submit()">
                </form>
                <div style="min-width: 110px; text-align: right; font-weight: 500;">
                    {{ number_format($ligne['sous_total'], 0, ',', ' ') }} FCFA
                </div>
                <form method="POST" action="{{ route('boutique.panier.retirer', $cle) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ligne" style="padding: 7px 12px; font-size: 12px;">Retirer</button>
                </form>
            </div>
        @endforeach

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; flex-wrap: wrap; gap: 14px;">
            <div>
                <div style="font-size: 13px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris);">Total</div>
                <div class="serif" style="font-size: 28px;">{{ number_format($total, 0, ',', ' ') }} FCFA</div>
                <div style="font-size: 13px; color: var(--gris);">{{ config('boutique.delai_livraison') }}</div>
            </div>
            <a href="{{ route('boutique.commande') }}" class="btn btn-noir">Passer la commande</a>
        </div>
    </div>

    <p style="text-align: center; font-size: 14px; color: var(--gris);">
        Un doute avant de commander ?
        <a href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener">Écrivez-nous sur WhatsApp</a>, on vous répond vite.
    </p>
@endif

@endsection
