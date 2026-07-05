@extends('layouts.admin')

@section('titre', 'Commande n°' . $commande->id)

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Commande {{ $commande->reference ?? 'n°' . $commande->id }}</div>
        <h1>{{ $commande->client?->prenom }} {{ $commande->client?->nom }}</h1>
    </div>
    <a href="{{ route('admin.commandes.index') }}" class="btn btn-ligne">← Retour aux commandes</a>
</div>

<div class="carte">
    <div class="grille-3">
        <div>
            <label>Cliente</label>
            <p><strong>{{ $commande->client?->prenom }} {{ $commande->client?->nom }}</strong><br>
            {{ $commande->client?->telephone }}<br>
            <small style="color: var(--gris)">{{ $commande->client?->email }}</small></p>
        </div>
        <div>
            <label>Livraison</label>
            <p>{{ $commande->adresse_livraison ?? $commande->client?->adresse ?? '—' }}<br>
            <small style="color: var(--gris)">Délai annoncé : {{ $commande->delai ?? '1 à 3 jours' }}</small></p>
        </div>
        <div>
            <label>Paiement</label>
            <p>{{ $commande->paiementLisible() }}<br>
            <small style="color: var(--gris)">{{ $commande->reference ?? 'Sans référence' }} · {{ $commande->created_at?->format('d/m/Y à H:i') }}</small></p>
        </div>
    </div>

    @if ($commande->emballage_cadeau)
        <div style="margin-top: 14px; padding: 13px 16px; background: #FBF6EA; border-left: 3px solid var(--or);">
            🎁 <strong>Commande cadeau</strong> — prévoir l'emballage.
            @if ($commande->message_cadeau)
                Mot à glisser : « {{ $commande->message_cadeau }} »
            @endif
        </div>
    @endif
</div>

<div class="carte">
    <table>
        <thead>
            <tr><th></th><th>Sac</th><th>Couleur</th><th>Qté</th><th>Prix unitaire</th><th>Sous-total</th></tr>
        </thead>
        <tbody>
            @foreach ($commande->lignes as $ligne)
                <tr>
                    <td>
                        @if ($ligne->produit?->imagePrincipale)
                            <img class="vignette" src="{{ $ligne->produit->imagePrincipale->lien() }}" alt="">
                        @else
                            <div class="vignette-vide">photo</div>
                        @endif
                    </td>
                    <td><strong>{{ $ligne->produit?->nom ?? 'Produit supprimé' }}</strong></td>
                    <td>{{ $ligne->couleur ?? '—' }}</td>
                    <td>{{ $ligne->quantite }}</td>
                    <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td>{{ number_format($ligne->prix_unitaire * $ligne->quantite, 0, ',', ' ') }} F</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right; font-weight: 600;">Total</td>
                <td style="font-weight: 600;">{{ $commande->totalFormate() }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="carte">
    <form method="POST" action="{{ route('admin.commandes.statut', $commande) }}" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
        @csrf
        @method('PATCH')
        <div class="champ" style="margin: 0; min-width: 240px;">
            <label for="statut">Statut de la commande</label>
            <select id="statut" name="statut">
                @foreach ($statuts as $valeur => $libelle)
                    <option value="{{ $valeur }}" @selected($commande->statut === $valeur)>{{ $libelle }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-or">Mettre à jour</button>
    </form>
    <p style="margin-top: 12px; font-size: 13.5px; color: var(--gris);">
        Parcours type : En attente → Payée → En livraison → Livrée. « Annulée » libère la cliente sans supprimer l'historique.
    </p>
</div>

@endsection
