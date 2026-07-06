{{-- Formulaire partagé entre create et edit. $produit est null en création. --}}

@csrf

<div class="carte">
    <div class="grille-2">
        <div class="champ">
            <label for="nom">Nom du sac *</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required placeholder="Ex : Joyau de Bla — édition bureau">
        </div>
        <div class="champ">
            <label for="categorie_id">Collection *</label>
            <select id="categorie_id" name="categorie_id" required>
                <option value="">Choisir…</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected(old('categorie_id', $produit->categorie_id ?? null) == $categorie->id)>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grille-3">
        <div class="champ">
            <label for="prix">Prix (FCFA) *</label>
            <input type="number" id="prix" name="prix" value="{{ old('prix', $produit->prix ?? '') }}" required min="0" step="500" placeholder="65 000">
        </div>
        <div class="champ">
            <label for="stock">Stock *</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $produit->stock ?? 0) }}" required min="0">
        </div>
        <div class="champ">
            <label for="dimensions">Dimensions</label>
            <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $produit->dimensions ?? '') }}" placeholder="30 × 22 × 12 cm">
        </div>
    </div>

    <div class="grille-2">
        <div class="champ">
            <label for="matiere">Matière</label>
            <select id="matiere" name="matiere">
                <option value="">—</option>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere }}" @selected(old('matiere', $produit->matiere ?? null) === $matiere)>{{ $matiere }}</option>
                @endforeach
            </select>
        </div>
        <div class="champ">
            <label for="occasion">Occasion</label>
            <select id="occasion" name="occasion">
                <option value="">—</option>
                @foreach ($occasions as $occasion)
                    <option value="{{ $occasion }}" @selected(old('occasion', $produit->occasion ?? null) === $occasion)>{{ $occasion }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="champ">
        <label for="modele_parent_id">Rattacher à un modèle existant (variante de couleur)</label>
        <select id="modele_parent_id" name="modele_parent_id">
            <option value="">— Nouveau modèle indépendant —</option>
            @foreach ($sacsExistants as $sac)
                <option value="{{ $sac->id }}" @selected(old('modele_parent_id') == $sac->id)>{{ $sac->nom }}</option>
            @endforeach
        </select>
        <p style="font-size: 13px; color: var(--gris); margin-top: 6px;">
            Exemple : vous créez « Joyau de Bla — Rouge » ? Rattachez-le à « Joyau de Bla — Noir »
            pour que les pastilles de couleur relient les deux fiches sur le site.
        </p>
    </div>

    <div class="champ">
        <label>Couleurs disponibles</label>
        <div class="choix-couleurs">
            @php $couleursChoisies = old('couleurs', isset($produit) ? $produit->couleurs->pluck('id')->all() : []); @endphp
            @foreach ($couleurs as $couleur)
                <label>
                    <input type="checkbox" name="couleurs[]" value="{{ $couleur->id }}" @checked(in_array($couleur->id, $couleursChoisies))>
                    <span class="pastille" style="background: {{ $couleur->code_hex }}"></span>
                    {{ $couleur->nom }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<div class="carte">
    <div class="champ">
        <label for="description">Description (matières, finitions, usage — rassure la cliente)</label>
        <textarea id="description" name="description" placeholder="Décrivez le sac : finitions, poches, fermeture, entretien…">{{ old('description', $produit->description ?? '') }}</textarea>
    </div>
    <div class="champ">
        <label for="histoire">Histoire du modèle (storytelling)</label>
        <textarea id="histoire" name="histoire" placeholder="L'inspiration derrière le modèle : la poupée Joyaux de Bla, l'héritage ashanti…">{{ old('histoire', $produit->histoire ?? '') }}</textarea>
    </div>
</div>

<div class="carte">
    <div class="champ">
        <label for="images">Photos ({{ isset($produit) && $produit->images->count() ? 'ajouter d\'autres images' : 'jusqu\'à 6 images — la première devient la couverture' }})</label>
        <input type="file" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/webp">
    </div>

    @if (isset($produit) && $produit->images->isNotEmpty())
        <label style="margin-top: 8px;">Images actuelles</label>
        <div class="galerie">
            @foreach ($produit->images as $image)
                <div class="item {{ $image->principale ? 'couverture' : '' }}">
                    @if ($image->principale)
                        <span class="badge-cover">Couverture</span>
                    @endif
                    <img src="{{ $image->lien() }}" alt="">
                    <div class="actions">
                        @unless ($image->principale)
                            <button type="submit" form="cover-{{ $image->id }}" class="btn btn-ligne btn-petit">Couverture</button>
                        @endunless
                        <button type="submit" form="suppr-image-{{ $image->id }}" class="btn btn-danger btn-petit"
                                onclick="return confirm('Supprimer cette image ?')">Retirer</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="carte">
    <div class="grille-2">
        <label class="interrupteur">
            <input type="checkbox" name="actif" value="1" @checked(old('actif', $produit->actif ?? true))>
            <span>Visible sur le site</span>
        </label>
        <label class="interrupteur">
            <input type="checkbox" name="mis_en_avant" value="1" @checked(old('mis_en_avant', $produit->mis_en_avant ?? false))>
            <span>Mettre en avant sur l'accueil</span>
        </label>
    </div>
</div>

<div style="display: flex; gap: 12px;">
    <button type="submit" class="btn btn-or">{{ isset($produit) ? 'Enregistrer les modifications' : 'Ajouter le sac' }}</button>
    <a href="{{ route('admin.produits.index') }}" class="btn btn-ligne">Annuler</a>
</div>
