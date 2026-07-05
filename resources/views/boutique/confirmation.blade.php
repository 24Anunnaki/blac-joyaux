@extends('boutique.layout')

@section('titre', 'Merci pour votre commande — Blac Joyaux')

@section('contenu')

<div style="max-width: 620px; margin: 0 auto; text-align: center;">
    <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--ok); color: #fff; font-size: 30px; display: flex; align-items: center; justify-content: center; margin: 12px auto 18px;">✓</div>

    <h1 style="font-size: clamp(28px, 5vw, 38px);">Merci, {{ $commande->client->prenom }} !</h1>
    <p style="color: var(--gris); margin-top: 6px;">
        @if ($commande->mode_paiement === 'especes')
            Votre commande est enregistrée. Vous réglerez <strong>{{ $commande->totalFormate() }}</strong> en espèces à la livraison.
        @else
            Votre paiement {{ $commande->paiementLisible() }} de <strong>{{ $commande->totalFormate() }}</strong> est confirmé.
        @endif
    </p>

    <div class="carte" style="text-align: left; margin-top: 26px;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 14px;">
            <div>
                <div style="font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris);">Référence</div>
                <strong>{{ $commande->reference }}</strong>
            </div>
            <div>
                <div style="font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris);">Livraison</div>
                <strong>{{ $commande->adresse_livraison }}</strong> · sous {{ $commande->delai }}
            </div>
        </div>

        @foreach ($commande->lignes as $ligne)
            <div style="display: flex; gap: 14px; align-items: center; padding: 10px 0; border-top: 1px solid var(--ligne);">
                <div style="width: 56px; height: 56px; background: var(--creme); border: 1px solid var(--ligne); overflow: hidden; flex-shrink: 0;">
                    @if ($ligne->produit?->imagePrincipale)
                        <img src="{{ $ligne->produit->imagePrincipale->lien() }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div style="flex: 1;">
                    <strong>{{ $ligne->produit?->nom ?? 'Sac' }}</strong>
                    <div style="font-size: 13.5px; color: var(--gris);">
                        @if ($ligne->couleur){{ $ligne->couleur }} · @endif Quantité : {{ $ligne->quantite }}
                    </div>
                </div>
                <div>{{ number_format($ligne->prix_unitaire * $ligne->quantite, 0, ',', ' ') }} F</div>
            </div>
        @endforeach

        @if ($commande->emballage_cadeau)
            <div style="margin-top: 14px; padding: 14px; background: #FBF6EA; border-left: 3px solid var(--or); font-size: 14.5px;">
                🎁 Emballage cadeau inclus
                @if ($commande->message_cadeau)
                    — votre mot : « {{ $commande->message_cadeau }} »
                @endif
            </div>
        @endif
    </div>

    <p style="margin: 22px 0 12px; color: var(--gris); font-size: 15px;">
        Notre équipe vous contacte pour organiser la livraison. Une question tout de suite ?
    </p>
    <a class="btn btn-whatsapp" href="{{ $lienWhatsapp }}" target="_blank" rel="noopener">
        Suivre ma commande sur WhatsApp
    </a>

    <div style="margin-top: 26px;">
        <a href="{{ route('boutique.catalogue') }}" class="btn btn-ligne">Continuer la découverte</a>
    </div>
</div>

@endsection
