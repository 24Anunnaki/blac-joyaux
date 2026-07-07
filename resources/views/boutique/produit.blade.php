@extends('boutique.layout')

@section('titre', $produit->nom . ' — Blac Joyaux')

@section('contenu')

<div class="fiche-produit" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">

    {{-- COLONNE GAUCHE : IMAGE --}}
    <div class="galerie-fiche">
        <div class="principale" style="aspect-ratio: 4/5; background: var(--blanc-chaud); border: 1px solid var(--ligne); display: flex; align-items: center; justify-content: center; color: var(--gris); overflow: hidden;">
            @if ($produit->imagePrincipale)
                <img id="fp-image" src="{{ $produit->imagePrincipale->lien() }}" alt="Sac {{ $produit->nom }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                Photo à venir
            @endif
        </div>

        {{-- GALERIE — TOUTES LES PHOTOS --}}
        @if ($produit->images->count() > 1)
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 10px;">
                @foreach ($produit->images as $photo)
                    <div style="aspect-ratio: 1/1; border: 1px solid var(--ligne); overflow: hidden; cursor: pointer;">
                        <img src="{{ $photo->lien() }}" alt="Sac {{ $produit->nom }} — photo {{ $loop->iteration }}" style="width: 100%; height: 100%; object-fit: cover;" onclick="document.getElementById('fp-image').src=this.src">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    {{-- COLONNE DROITE : INFOS --}}
    <div>
        <div class="fil">{{ $produit->categorie->nom }}</div>
        <h1 style="font-size: clamp(30px, 4.5vw, 40px);">{{ $produit->nom }}</h1>
        <p style="font-size: 24px; margin: 8px 0 4px;">{{ $produit->prixFormate() }}</p>

        {{-- PASTILLES DE COULEUR (variantes du même modèle) --}}
        @isset($variantes)
            @if ($variantes->count() > 1)
                <div style="margin: 22px 0;">
                    <div style="font-size: 12px; letter-spacing: .12em; text-transform: uppercase; color: var(--gris); margin-bottom: 10px;">
                        Coloris disponibles — {{ $variantes->count() }}
                    </div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach ($variantes as $variante)
                            <a href="{{ route('boutique.produit', $variante->slug) }}"
                               title="{{ $variante->couleurs->first()->nom ?? $variante->nom }}"
                               style="width: 30px; height: 30px; border-radius: 50%; display: inline-block;
                                      background: {{ $variante->couleurs->first()->code_hex ?? '#cccccc' }};
                                      border: 2px solid {{ $variante->id === $produit->id ? 'var(--or)' : 'transparent' }};
                                      box-shadow: inset 0 0 0 1px rgba(0,0,0,.08);"></a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endisset

        @if ($produit->description)
            <p style="margin-top: 16px;">{{ $produit->description }}</p>
        @endif

        {{-- BOUTON AJOUTER AU PANIER --}}
        <form method="POST" action="{{ route('boutique.panier.ajouter', $produit) }}" style="margin-top: 22px;">
            @csrf
            <button type="submit" class="btn btn-noir" style="width: 100%;" {{ $produit->stock < 1 ? 'disabled' : '' }}>
                Ajouter au panier
            </button>
        </form>

        {{-- BOUTON WHATSAPP --}}
        <a class="btn btn-whatsapp btn-large" style="margin-top: 12px;"
           href="{{ $lienWhatsapp }}" target="_blank" rel="noopener">
            Poser une question sur WhatsApp
        </a>
    </div>

</div>

@endsection
