@extends('boutique.layout')

@section('titre', 'Paiement — Blac Joyaux')

@section('contenu')

<div class="fil">Paiement sécurisé</div>
<h1 class="titre-page">Choisissez votre moyen de paiement</h1>

<div style="max-width: 560px;">
    <div class="carte" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris);">Montant à régler</div>
            <div class="serif" style="font-size: 30px;">{{ $commande->totalFormate() }}</div>
        </div>
        <div style="text-align: right; font-size: 13.5px; color: var(--gris);">
            Commande n° {{ $commande->id }}<br>{{ $commande->lignes->sum('quantite') }} article(s)
        </div>
    </div>

    <form method="POST" action="{{ route('boutique.paiement.simuler', $commande) }}" id="form-paiement">
        @csrf
        <div class="carte">
            <style>
                .choix-paiement { display: grid; gap: 10px; }
                .choix-paiement label {
                    display: flex; align-items: center; gap: 12px; cursor: pointer;
                    border: 1px solid var(--ligne); padding: 14px 16px; margin: 0;
                    font-size: 16px; text-transform: none; letter-spacing: 0; color: var(--encre);
                    transition: border-color .15s;
                }
                .choix-paiement label:has(input:checked) { border-color: var(--or); background: #FBF6EA; }
                .choix-paiement input { accent-color: var(--or); width: 17px; height: 17px; }
                .pastille-op { width: 34px; height: 34px; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 600; flex-shrink: 0; }
            </style>
            <div class="choix-paiement">
                <label>
                    <input type="radio" name="mode_paiement" value="orange_money" required
                           @checked(old('mode_paiement', 'orange_money') === 'orange_money')>
                    <span class="pastille-op" style="background: #FF7900;">OM</span>
                    Orange Money
                </label>
                <label>
                    <input type="radio" name="mode_paiement" value="mtn_money" @checked(old('mode_paiement') === 'mtn_money')>
                    <span class="pastille-op" style="background: #FFCB05; color: #141110;">MTN</span>
                    MTN Mobile Money
                </label>
                <label>
                    <input type="radio" name="mode_paiement" value="wave" @checked(old('mode_paiement') === 'wave')>
                    <span class="pastille-op" style="background: #00A8E8;">W</span>
                    Wave
                </label>
                <label>
                    <input type="radio" name="mode_paiement" value="especes" @checked(old('mode_paiement') === 'especes')>
                    <span class="pastille-op" style="background: var(--noir); color: var(--or-clair);">₣</span>
                    Espèces à la livraison
                </label>
            </div>

            <div id="bloc-numero" class="champ" style="margin-top: 18px;">
                <label for="numero">Numéro Mobile Money à débiter</label>
                <input type="tel" id="numero" name="numero" value="{{ old('numero') }}" placeholder="07 00 00 00 00">
                <p style="font-size: 13px; color: var(--gris); margin-top: 6px;">
                    Vous recevrez une demande de validation sur votre téléphone.
                </p>
            </div>
        </div>

        <button type="submit" class="btn btn-noir btn-large" id="btn-payer">Payer {{ $commande->totalFormate() }}</button>
        <p style="text-align: center; font-size: 12.5px; color: var(--gris); margin-top: 10px;">
            Démonstration : paiement simulé, aucun débit réel n'est effectué.
        </p>
    </form>
</div>

<script>
    // Masquer le champ numéro pour le paiement en espèces
    const radios = document.querySelectorAll('input[name="mode_paiement"]');
    const blocNumero = document.getElementById('bloc-numero');
    const majNumero = () => {
        const especes = document.querySelector('input[name="mode_paiement"]:checked')?.value === 'especes';
        blocNumero.style.display = especes ? 'none' : 'block';
    };
    radios.forEach(r => r.addEventListener('change', majNumero));
    majNumero();

    // Simulation réaliste : le bouton affiche les étapes d'une vraie transaction Mobile Money
    document.getElementById('form-paiement').addEventListener('submit', function (e) {
        const btn = document.getElementById('btn-payer');
        const especes = document.querySelector('input[name="mode_paiement"]:checked')?.value === 'especes';
        if (btn.dataset.enCours || especes) return; // espèces : validation immédiate
        e.preventDefault();
        btn.dataset.enCours = '1';
        btn.disabled = true;
        btn.textContent = 'Connexion à l\'opérateur…';
        setTimeout(() => { btn.textContent = 'Validez sur votre téléphone…'; }, 1200);
        setTimeout(() => { btn.textContent = 'Paiement confirmé ✓'; this.submit(); }, 3000);
    });
</script>

@endsection
