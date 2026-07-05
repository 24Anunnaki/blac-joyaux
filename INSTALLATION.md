# Module Administration — Blac Joyaux
### Adapté au schéma de base de données de l'équipe

Partie admin pour gérer le catalogue de sacs, calquée sur votre schéma MySQL :
`categories`, `produits`, `produit_images`, `clients`, `commandes`, `lignes_commandes`.

## Correspondance avec votre schéma

| Votre table | Utilisée par l'admin | Colonnes ajoutées par le module |
|---|---|---|
| `categories` | ✅ gestion des collections | `slug`, timestamps |
| `produits` | ✅ CRUD complet | `nom` (absente du schéma !), `slug`, `occasion`, `histoire`, `actif`, `mis_en_avant`, timestamps |
| `produit_images` | ✅ upload photos (colonne `url`, FK `product_id` respectées) | `principale` (image de couverture), timestamps |
| `clients` | modèle prêt (pour la suite : commandes) | — |
| `commandes` | modèle prêt avec statuts | — |
| `lignes_commandes` | modèle prêt | — |
| `couleurs` + `couleur_produit` | ✅ nouvelles tables (filtre couleur du front) | créées par le module |

⚠️ **Important** : votre table `PRODUITS` n'avait pas de colonne `NOM`. La migration
`completer_schema_pour_admin` l'ajoute automatiquement. Toutes les migrations sont
**protégées** (`hasTable` / `hasColumn`) : elles ne touchent jamais à ce qui existe déjà
dans votre base. Vous pouvez lancer `php artisan migrate` sans risque.

## Installation

1. **Copier les dossiers** `app/`, `database/`, `resources/`, `routes/` à la racine du projet Laravel.

2. **Brancher les routes** — dans `routes/web.php`, ajouter à la fin :
```php
require __DIR__.'/admin.php';
```

3. **Configurer `.env`** :
```
DB_CONNECTION=mysql
DB_DATABASE=blac_joyaux
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

4. **Migrer et alimenter** :
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan storage:link
```

Le seeder crée le compte admin `admin@blacjoyaux.com` / `BlacJoyaux2026!` (**à changer**),
les collections du brief (Joyau de Bla, Collection DO, Sac de bureau, Capsule) et 6 couleurs.

5. **Se connecter** sur `/admin/login` après `php artisan serve`.

## Pages de l'admin

- `/admin/sacs` — liste + filtres (recherche, collection, couleur, matière, occasion, prix max)
- `/admin/sacs/create` — ajout : nom, collection, prix FCFA, stock, dimensions, matière, occasion, couleurs, description, histoire, jusqu'à 6 photos
- `/admin/sacs/{id}/edit` — modification + gestion des photos (couverture, suppression)
- `/admin/collections` et `/admin/couleurs`

## Réutiliser les filtres sur le front-end

Le scope `filtre()` du modèle `Produit` est prêt pour votre page catalogue :

```php
use App\Models\Produit;

$sacs = Produit::where('actif', true)
    ->with(['imagePrincipale', 'couleurs', 'categorie'])
    ->filtre($request->all())
    ->paginate(12);
```

Paramètres d'URL : `?categorie=1&couleur=2&matiere=Cuir&occasion=Cadeau&prix_min=40000&prix_max=100000&recherche=bureau`

Pour afficher une image : `$sac->imagePrincipale?->lien()` — et le prix : `$sac->prixFormate()` (ex. « 65 000 FCFA »).

Les listes de matières et d'occasions sont centralisées dans `Produit::matieres()` et
`Produit::occasions()` : un seul endroit à modifier pour l'admin **et** le front.

## Prochaine étape naturelle

Les modèles `Client`, `Commande` et `LigneCommande` sont déjà mappés sur vos tables :
il ne reste qu'à créer la page admin des commandes (liste + changement de statut) et
le tunnel d'achat côté front avec la simulation Mobile Money. Demandez et je les génère.

---

## Mise à jour : boutique publique + commandes (ajoutée le 04/07/2026)

Nouveautés dans le projet :
- **Site public** : accueil, catalogue `/sacs` avec filtres, fiche produit `/sacs/{slug}`
  (galerie, histoire, FAQ, bouton WhatsApp pré-rempli, données structurées JSON-LD)
- **Panier** en session (achat invité, sans compte)
- **Commande** : formulaire mobile-first avec quartiers d'Abidjan et **mode cadeau**
- **Paiement simulé** Mobile Money (Orange, MTN, Wave) ou espèces à la livraison
- **Admin > Commandes** : liste filtrable, détail, changement de statut

À faire après avoir récupéré cette version :
```bash
php artisan migrate        # ajoute reference, emballage_cadeau... aux commandes
php artisan config:clear
```

Configurer le numéro WhatsApp de la marque dans le `.env` :
```
BOUTIQUE_WHATSAPP=2250701020304
```
(format international sans le +, sinon un numéro fictif est utilisé)
