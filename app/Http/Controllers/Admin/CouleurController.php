<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Couleur;
use Illuminate\Http\Request;

class CouleurController extends Controller
{
    public function index()
    {
        $couleurs = Couleur::withCount('produits')->orderBy('nom')->get();

        return view('admin.couleurs', compact('couleurs'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'code_hex' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        Couleur::create($donnees);

        return back()->with('succes', 'Couleur ajoutée.');
    }

    public function destroy(Couleur $couleur)
    {
        $couleur->delete();

        return back()->with('succes', 'Couleur supprimée.');
    }
}
