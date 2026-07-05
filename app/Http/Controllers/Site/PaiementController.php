<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function show(Commande $commande)
    {
        if ($commande->statut !== 'en_attente') {
            return redirect()->route('confirmation', $commande);
        }

        $commande->load('lignes.produit');

        return view('site.paiement', compact('commande'));
    }

    /**
     * SIMULATION de paiement Mobile Money (exigence du brief : paiement simulé).
     * Aucun vrai débit : on valide le format du numéro puis on marque la commande payée.
     */
    public function simuler(Request $request, Commande $commande)
    {
        abort_if($commande->statut !== 'en_attente', 403);

        $donnees = $request->validate([
            'mode_paiement' => ['required', 'in:orange_money,mtn_money,wave,especes'],
            'numero' => ['required_unless:mode_paiement,especes', 'nullable', 'regex:/^(\+?225)?[0-9]{10}$/'],
        ], [
            'numero.regex' => 'Entrez un numéro ivoirien valide (10 chiffres).',
            'numero.required_unless' => 'Le numéro Mobile Money est requis.',
        ]);

        $commande->update([
            'statut' => $donnees['mode_paiement'] === 'especes' ? 'en_attente' : 'payee',
            'mode_paiement' => $donnees['mode_paiement'],
        ]);

        return redirect()->route('confirmation', $commande);
    }

    public function confirmation(Commande $commande)
    {
        $commande->load(['lignes.produit', 'client']);

        $numero = config('services.whatsapp.numero');
        $message = rawurlencode(
            "Bonjour Blac Joyaux ! Je viens de passer la commande {$commande->reference} ({$commande->totalFormate()}). Pouvez-vous me confirmer la livraison ?"
        );
        $lienWhatsApp = "https://wa.me/{$numero}?text={$message}";

        return view('site.confirmation', compact('commande', 'lienWhatsApp'));
    }
}
