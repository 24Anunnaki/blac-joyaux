@extends('boutique.layout')

@section('titre', 'Finaliser ma commande — Blac Joyaux')

@section('contenu')

<div class="fil">Dernière étape</div>
<h1 class="titre-page">Vos informations de livraison</h1>

<div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 28px; align-items: start;" class="colonne-commande">
    <style>@media (max-width: 780px) { .colonne-commande { grid-template-columns: 1fr !important; } }</style>

    <form method="POST" action="{{ route('boutique.commande.store') }}">
        @csrf
        <div class="carte">
            <p style="font-size: 14px; color: var(--gris); margin-bottom: 18px;">
                Pas besoin de créer un compte : ces informations servent uniquement à vous livrer.
            </p>
            <div class="grille-2">
                <div class="champ">
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                </div>
                <div class="champ">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
                </div>
            </div>
            <div class="grille-2">
                <div class="champ">
                    <label for="telephone">Téléphone (le livreur vous appelle) *</label>
                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" required placeholder="07 00 00 00 00">
                </div>
                <div class="champ">
                    <label for="email">E-mail (facultatif)</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="grille-2">
                <div class="champ">
                    <label for="quartier">Quartier de livraison *</label>
                    <select id="quartier" name="quartier" required>
                        <option value="">Choisir…</option>
                        @foreach ($quartiers as $quartier)
                            <option value="{{ $quartier }}" @selected(old('quartier') === $quartier)>{{ $quartier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="champ">
                    <label for="adresse">Précisions (rue, repère…)</label>
                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" placeholder="Ex : rue des Jardins, près de la pharmacie">
                </div>
            </div>
        </div>

        <div class="carte" style="border-left: 3px solid var(--or);">
            <label style="display: flex; align-items: center; gap: 10px; text-transform: none; font-size: 16px; color: var(--encre); cursor: pointer;">
                <input type="checkbox" name="emballage_cadeau" value="1" @checked(old('emballage_cadeau'))
                       onchange="document.getElementById('bloc-cadeau').style.display = this.checked ? 'block' : 'none'"
                       style="width: 18px; height: 18px; accent-color: var(--or);">
                <span><strong class="serif" style="font-size: 19px;">C'est pour offrir</strong> — emballage cadeau élégant offert</span>
            </label>
            <div id="bloc-cadeau" style="display: {{ old('emballage_cadeau') ? 'block' : 'none' }}; margin-top: 16px;">
                <label for="message_cadeau">Votre petit mot (glissé dans le paquet)</label>
                <textarea id="message_cadeau" name="message_cadeau" maxlength="300" placeholder="Ex : Joyeux anniversaire ma belle, ce joyau est à ton image.">{{ old('message_cadeau') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-noir btn-large">Continuer vers le paiement</button>
    </form>

    <div class="carte">
        <h2 style="font-size: 21px; margin-bottom: 14px;">Récapitulatif</h2>
        @foreach ($lignes as $ligne)
            <div style="display: flex; justify-content: space-between; gap: 12px; padding: 8px 0; border-bottom: 1px solid var(--ligne); font-size: 15px;">
                <span>{{ $ligne['produit']->nom }} @if($ligne['couleur'])({{ $ligne['couleur'] }})@endif × {{ $ligne['quantite'] }}</span>
                <span style="white-space: nowrap;">{{ number_format($ligne['sous_total'], 0, ',', ' ') }} F</span>
            </div>
        @endforeach
        <div style="display: flex; justify-content: space-between; padding-top: 14px; font-weight: 600; font-size: 17px;">
            <span>Total</span>
            <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
        </div>
        <p style="font-size: 13px; color: var(--gris); margin-top: 10px;">
            {{ config('boutique.delai_livraison') }} · Paiement Mobile Money ou espèces à la livraison.
        </p>
    </div>
</div>

@endsection
