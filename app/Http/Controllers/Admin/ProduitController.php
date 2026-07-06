<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Produit;
use App\Models\ProduitImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    /**
     * Liste des sacs avec les mêmes filtres que le front-end.
     */
    public function index(Request $request)
    {
        $produits = Produit::with(['categorie', 'imagePrincipale', 'couleurs'])
            ->filtre($request->all())
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.produits.index', [
            'produits' => $produits,
            'categories' => Categorie::orderBy('nom')->get(),
            'couleurs' => Couleur::orderBy('nom')->get(),
            'matieres' => Produit::matieres(),
            'occasions' => Produit::occasions(),
        ]);
    }

    public function create()
    {
        return view('admin.produits.create', [
            'categories' => Categorie::orderBy('nom')->get(),
            'couleurs' => Couleur::orderBy('nom')->get(),
            'matieres' => Produit::matieres(),
            'occasions' => Produit::occasions(),
            'sacsExistants' => Produit::orderBy('nom')->get(['id', 'nom']),
        ]);
    }

    public function store(Request $request)
    {
        $donnees = $this->valider($request);

        $donnees['slug'] = $this->genererSlug($donnees['nom']);
        $donnees['actif'] = $request->boolean('actif');
        $donnees['mis_en_avant'] = $request->boolean('mis_en_avant');

        $produit = Produit::create($donnees);
        $produit->couleurs()->sync($request->input('couleurs', []));

        // Variantes de couleur (Option A) : relier les coloris d'un même modèle
        if ($request->filled('modele_parent_id')) {
            // On rattache ce coloris à un modèle existant :
            // on reprend le modele_id du parent choisi.
            $parent = Produit::findOrFail($request->modele_parent_id);
            $produit->modele_id = $parent->modele_id ?? $parent->id;
        } else {
            // Premier coloris d'un nouveau modèle :
            // il devient son propre chef de file.
            $produit->modele_id = $produit->id;
        }
        $produit->save();

        $this->enregistrerImages($request, $produit);

        return redirect()->route('admin.produits.index')
            ->with('succes', "Le sac « {$produit->nom} » a été ajouté.");
    }

    public function edit(Produit $produit)
    {
        $produit->load(['couleurs', 'images']);

        return view('admin.produits.edit', [
            'produit' => $produit,
            'categories' => Categorie::orderBy('nom')->get(),
            'couleurs' => Couleur::orderBy('nom')->get(),
            'matieres' => Produit::matieres(),
            'occasions' => Produit::occasions(),
            'sacsExistants' => Produit::where('id', '!=', $produit->id)->orderBy('nom')->get(['id', 'nom']),
        ]);
    }

    public function update(Request $request, Produit $produit)
    {
        $donnees = $this->valider($request);

        if ($donnees['nom'] !== $produit->nom) {
            $donnees['slug'] = $this->genererSlug($donnees['nom'], $produit->id);
        }

        $donnees['actif'] = $request->boolean('actif');
        $donnees['mis_en_avant'] = $request->boolean('mis_en_avant');

        $produit->update($donnees);
        $produit->couleurs()->sync($request->input('couleurs', []));

        // Variantes de couleur (Option A) : re-rattachement possible depuis l'édition
        if ($request->filled('modele_parent_id')) {
            $parent = Produit::findOrFail($request->modele_parent_id);
            $produit->modele_id = $parent->modele_id ?? $parent->id;
            $produit->save();
        } elseif (! $produit->modele_id) {
            $produit->modele_id = $produit->id;
            $produit->save();
        }

        $this->enregistrerImages($request, $produit);

        return redirect()->route('admin.produits.index')
            ->with('succes', "Le sac « {$produit->nom} » a été mis à jour.");
    }

    public function destroy(Produit $produit)
    {
        foreach ($produit->images as $image) {
            Storage::disk('public')->delete($image->url);
        }

        $produit->delete();

        return back()->with('succes', 'Le sac a été supprimé.');
    }

    /**
     * Supprime une image précise depuis le formulaire d'édition.
     */
    public function destroyImage(Produit $produit, ProduitImage $image)
    {
        abort_unless($image->product_id === $produit->id, 404);

        Storage::disk('public')->delete($image->url);
        $etaitPrincipale = $image->principale;
        $image->delete();

        // Si on supprime la couverture, la première image restante la remplace
        if ($etaitPrincipale && $suivante = $produit->images()->first()) {
            $suivante->update(['principale' => true]);
        }

        return back()->with('succes', 'Image supprimée.');
    }

    /**
     * Définit une image comme couverture.
     */
    public function setCover(Produit $produit, ProduitImage $image)
    {
        abort_unless($image->product_id === $produit->id, 404);

        $produit->images()->update(['principale' => false]);
        $image->update(['principale' => true]);

        return back()->with('succes', 'Image de couverture mise à jour.');
    }

    /* ----------------- Méthodes privées ----------------- */

    private function valider(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'prix' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'matiere' => ['nullable', 'string', 'max:100'],
            'occasion' => ['nullable', 'string', 'max:100'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'histoire' => ['nullable', 'string'],
            'couleurs' => ['array'],
            'couleurs.*' => ['exists:couleurs,id'],
            'images' => ['array', 'max:6'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'nom.required' => 'Le nom du sac est obligatoire.',
            'categorie_id.required' => 'Choisissez une collection.',
            'prix.required' => 'Indiquez le prix en FCFA.',
            'images.*.image' => 'Chaque fichier doit être une image (jpg, png ou webp).',
            'images.*.max' => 'Chaque image doit faire moins de 4 Mo.',
        ]);
    }

    private function genererSlug(string $nom, ?int $ignorerId = null): string
    {
        $base = Str::slug($nom);
        $slug = $base;
        $i = 2;

        while (Produit::where('slug', $slug)
            ->when($ignorerId, fn ($q) => $q->where('id', '!=', $ignorerId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function enregistrerImages(Request $request, Produit $produit): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $ordre = (int) $produit->images()->max('ordre');
        $aDejaUneCouverture = $produit->images()->where('principale', true)->exists();

        foreach ($request->file('images') as $fichier) {
            $chemin = $fichier->store('produits', 'public');

            $produit->images()->create([
                'url' => $chemin,
                'principale' => ! $aDejaUneCouverture,
                'ordre' => ++$ordre,
            ]);

            $aDejaUneCouverture = true;
        }
    }
}
