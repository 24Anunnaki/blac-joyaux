<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('produits')->orderBy('nom')->get();

        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        Categorie::create([
            'nom' => $donnees['nom'],
            'slug' => Str::slug($donnees['nom']),
            'description' => $donnees['description'] ?? null,
        ]);

        return back()->with('succes', 'Collection ajoutée.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->produits()->exists()) {
            return back()->withErrors(['nom' => 'Impossible de supprimer : des sacs sont rattachés à cette collection.']);
        }

        $categorie->delete();

        return back()->with('succes', 'Collection supprimée.');
    }
}
