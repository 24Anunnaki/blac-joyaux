@extends('layouts.admin')

@section('titre', 'Commandes')

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Ventes</div>
        <h1>Commandes</h1>
    </div>
    @if ($enAttente > 0)
        <span class="etiquette" style="border-color: var(--or); color: var(--or);">{{ $enAttente }} en attente</span>
    @endif
</div>

<div class="carte">
    <form method="GET" action="{{ route('admin.commandes.index') }}" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
        <div class="champ" style="margin: 0; min-width: 220px;">
            <label for="statut">Filtrer par statut</label>
            <select id="statut" name="statut" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                @foreach ($statuts as $valeur => $libelle)
                    <option value="{{ $valeur }}" @selected(request('statut') === $valeur)>{{ $libelle }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="carte">
    @if ($commandes->isEmpty())
        <div class="vide">
            <div class="serif">Aucune commande pour l'instant</div>
            <p>Elles apparaîtront ici dès qu'une cliente commandera sur le site.</p>
        </div>
    @else
        <table>
            <thead>
                <tr><th>N°</th><th>Référence</th><th>Cliente</th><th>Articles</th><th>Total</th><th>Paiement</th><th>Statut</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
                @foreach ($commandes as $commande)
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ $commande->reference ?? '—' }}</td>
                        <td>
                            <strong>{{ $commande->client?->prenom }} {{ $commande->client?->nom }}</strong><br>
                            <small style="color: var(--gris)">{{ $commande->client?->telephone }}</small>
                        </td>
                        <td>{{ $commande->lignes_count }}</td>
                        <td>{{ $commande->totalFormate() }}</td>
                        <td>{{ $commande->paiementLisible() }}</td>
                        <td><span class="etiquette {{ in_array($commande->statut, ['payee', 'livree']) ? 'on' : '' }}">{{ $commande->statutLisible() }}</span></td>
                        <td>{{ $commande->created_at?->format('d/m/Y H:i') }}</td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-ligne btn-petit">Détail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">{{ $commandes->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection
