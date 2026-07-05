@extends('layouts.admin')

@section('titre', 'Couleurs')

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Catalogue</div>
        <h1>Couleurs</h1>
    </div>
</div>

<div class="carte">
    <form method="POST" action="{{ route('admin.couleurs.store') }}" style="display: flex; gap: 12px; align-items: flex-end;">
        @csrf
        <div class="champ" style="flex: 1; margin-bottom: 0;">
            <label for="nom">Nom de la couleur</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex : Camel">
        </div>
        <div class="champ" style="margin-bottom: 0;">
            <label for="code_hex">Teinte</label>
            <input type="color" id="code_hex" name="code_hex" value="#141110" style="width: 72px; height: 43px; padding: 4px; border: 1px solid var(--ligne); background: var(--blanc-chaud); cursor: pointer;">
        </div>
        <button type="submit" class="btn btn-or">Ajouter</button>
    </form>
</div>

<div class="carte">
    <table>
        <thead>
            <tr><th></th><th>Couleur</th><th>Code</th><th>Sacs</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($couleurs as $couleur)
                <tr>
                    <td><span class="pastille" style="background: {{ $couleur->code_hex }}; width: 22px; height: 22px;"></span></td>
                    <td><strong>{{ $couleur->nom }}</strong></td>
                    <td style="color: var(--gris)">{{ $couleur->code_hex }}</td>
                    <td>{{ $couleur->produits_count }}</td>
                    <td style="text-align: right;">
                        <form method="POST" action="{{ route('admin.couleurs.destroy', $couleur) }}"
                              onsubmit="return confirm('Supprimer la couleur « {{ $couleur->nom }} » ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-petit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="vide">Aucune couleur pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
