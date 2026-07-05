@extends('layouts.admin')

@section('titre', 'Sacs')

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Catalogue</div>
        <h1>Les sacs</h1>
    </div>
    <a href="{{ route('admin.produits.create') }}" class="btn btn-or">+ Ajouter un sac</a>
</div>

{{-- Barre de filtres : les mêmes critères que le catalogue du site --}}
<div class="carte">
    <form method="GET" action="{{ route('admin.produits.index') }}" class="filtres">
        <div class="champ">
            <label for="recherche">Recherche</label>
            <input type="text" id="recherche" name="recherche" value="{{ request('recherche') }}" placeholder="Nom du sac…">
        </div>
        <div class="champ">
            <label for="categorie">Collection</label>
            <select id="categorie" name="categorie">
                <option value="">Toutes</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ">
            <label for="couleur">Couleur</label>
            <select id="couleur" name="couleur">
                <option value="">Toutes</option>
                @foreach ($couleurs as $couleur)
                    <option value="{{ $couleur->id }}" @selected(request('couleur') == $couleur->id)>{{ $couleur->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ">
            <label for="matiere">Matière</label>
            <select id="matiere" name="matiere">
                <option value="">Toutes</option>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere }}" @selected(request('matiere') === $matiere)>{{ $matiere }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ">
            <label for="occasion">Occasion</label>
            <select id="occasion" name="occasion">
                <option value="">Toutes</option>
                @foreach ($occasions as $occasion)
                    <option value="{{ $occasion }}" @selected(request('occasion') === $occasion)>{{ $occasion }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ">
            <label for="prix_max">Prix max (FCFA)</label>
            <input type="number" id="prix_max" name="prix_max" value="{{ request('prix_max') }}" step="5000" min="0" placeholder="100 000">
        </div>
        <div class="champ">
            <button type="submit" class="btn btn-ligne">Filtrer</button>
        </div>
    </form>
</div>

<div class="carte">
    @if ($produits->isEmpty())
        <div class="vide">
            <div class="serif">Aucun sac ne correspond</div>
            <p>Modifiez les filtres ou ajoutez votre premier modèle.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Sac</th>
                    <th>Collection</th>
                    <th>Couleurs</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                    <tr>
                        <td>
                            @if ($produit->imagePrincipale)
                                <img class="vignette" src="{{ $produit->imagePrincipale->lien() }}" alt="{{ $produit->nom }}">
                            @else
                                <div class="vignette-vide">photo</div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $produit->nom }}</strong><br>
                            <small style="color: var(--gris)">{{ $produit->matiere ?? '—' }} · {{ $produit->occasion ?? '—' }}</small>
                        </td>
                        <td>{{ $produit->categorie->nom }}</td>
                        <td>
                            @foreach ($produit->couleurs as $couleur)
                                <span class="pastille" style="background: {{ $couleur->code_hex }}" title="{{ $couleur->nom }}"></span>
                            @endforeach
                        </td>
                        <td>{{ $produit->prixFormate() }}</td>
                        <td>{{ $produit->stock }}</td>
                        <td>
                            <span class="etiquette {{ $produit->actif ? 'on' : 'off' }}">
                                {{ $produit->actif ? 'En ligne' : 'Masqué' }}
                            </span>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-ligne btn-petit">Modifier</a>
                            <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}" style="display:inline"
                                  onsubmit="return confirm('Supprimer « {{ $produit->nom }} » ? Cette action est définitive.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-petit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $produits->links('pagination::simple-default') }}
        </div>
    @endif
</div>

@endsection
