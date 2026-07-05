@extends('layouts.admin')

@section('titre', 'Collections')

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Catalogue</div>
        <h1>Collections</h1>
    </div>
</div>

<div class="carte">
    <form method="POST" action="{{ route('admin.categories.store') }}" style="display: flex; gap: 12px; align-items: flex-end;">
        @csrf
        <div class="champ" style="flex: 1; margin-bottom: 0;">
            <label for="nom">Nouvelle collection</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex : Sac de bureau">
        </div>
        <button type="submit" class="btn btn-or">Ajouter</button>
    </form>
</div>

<div class="carte">
    <table>
        <thead>
            <tr><th>Collection</th><th>Slug</th><th>Sacs</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($categories as $categorie)
                <tr>
                    <td><strong>{{ $categorie->nom }}</strong></td>
                    <td style="color: var(--gris)">{{ $categorie->slug }}</td>
                    <td>{{ $categorie->produits_count }}</td>
                    <td style="text-align: right;">
                        <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}"
                              onsubmit="return confirm('Supprimer la collection « {{ $categorie->nom }} » ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-petit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="vide">Aucune collection pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
