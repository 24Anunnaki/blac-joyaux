<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    public function show(Commande $commande)
    {
        $this->verifierAcces($commande);

        if (in_array($commande->statut, ['payee', 'en_livraison', 'livree'])) {
            return redirect()->route('boutique.confirmation', $commande);
        }

        return view('boutique.paiement', [
            'commande' => $commande->load('lignes.produit'),
            'paiements' => Commande::PAIEMENTS,
        ]);
    }

    /**
     * SIMULATION Mobile Money (exigence du brief : paiement simulé).
     * Aucun vrai débit : on génère une référence et on valide la commande.
     */
    public function simuler(Request $request, Commande $commande)
    {
        $this->verifierAcces($commande);

        $donnees = $request->validate([
            'mode_paiement' => ['required', 'in:' . implode(',', array_keys(Commande::PAIEMENTS))],
            'numero' => ['required_unless:mode_paiement,especes', 'nullable', 'regex:/^[0-9\s+]{8,15}$/'],
        ], [
            'numero.required_unless' => 'Entrez le numéro Mobile Money à débiter.',
            'numero.regex' => 'Ce numéro ne semble pas valide.',
        ]);

        $commande->update([
            'mode_paiement' => $donnees['mode_paiement'],
            'reference' => 'BJ-' . now()->format('ymd') . '-' . strtoupper(Str::random(5)),
            // Espèces : payée à la livraison, la commande reste "en attente"
            'statut' => $donnees['mode_paiement'] === 'especes' ? 'en_attente' : 'payee',
        ]);

        return redirect()->route('boutique.confirmation', $commande);
    }

    public function confirmation(Commande $commande)
    {
        $this->verifierAcces($commande);

        $commande->load(['lignes.produit.imagePrincipale', 'client']);

        $message = rawurlencode(
            "Bonjour Blac Joyaux ! Je viens de passer la commande {$commande->reference} "
            . "d'un montant de {$commande->totalFormate()}. Pouvez-vous me confirmer la livraison ?"
        );
        $lienWhatsapp = 'https://wa.me/' . config('boutique.whatsapp') . '?text=' . $message;

        return view('boutique.confirmation', compact('commande', 'lienWhatsapp'));
    }

    /**
     * La cliente n'a pas de compte : on protège l'accès via la session.
     */
    private function verifierAcces(Commande $commande): void
    {
        abort_unless(session('derniere_commande') === $commande->id, 403);
    }
}
