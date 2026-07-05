<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produit extends Model
{
    protected $table = 'produits';

    protected $fillable = [
        'nom', 'slug', 'categorie_id', 'description', 'histoire',
        'prix', 'stock', 'matiere', 'occasion', 'dimensions',
        'actif', 'mis_en_avant',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'mis_en_avant' => 'boolean',
    ];

    /* ----- Relations (fidèles au schéma de l'équipe) ----- */

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function couleurs(): BelongsToMany
    {
        return $this->belongsToMany(Couleur::class, 'couleur_produit', 'produit_id', 'couleur_id');
    }

    // La FK de produit_images s'appelle product_id dans votre schéma
    public function images(): HasMany
    {
        return $this->hasMany(ProduitImage::class, 'product_id')->orderBy('ordre');
    }

    public function imagePrincipale(): HasOne
    {
        return $this->hasOne(ProduitImage::class, 'product_id')->where('principale', true);
    }

    public function lignesCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class, 'product_id');
    }

    /* ----- Scope de filtrage : à réutiliser tel quel sur le front ----- */
    /*  Produit::where('actif', true)->filtre($request->all())->paginate(12);  */

    public function scopeFiltre(Builder $query, array $filtres): Builder
    {
        return $query
            ->when($filtres['categorie'] ?? null, fn ($q, $id) =>
                $q->where('categorie_id', $id))
            ->when($filtres['couleur'] ?? null, fn ($q, $couleurId) =>
                $q->whereHas('couleurs', fn ($c) => $c->where('couleurs.id', $couleurId)))
            ->when($filtres['matiere'] ?? null, fn ($q, $matiere) =>
                $q->where('matiere', $matiere))
            ->when($filtres['occasion'] ?? null, fn ($q, $occasion) =>
                $q->where('occasion', $occasion))
            ->when($filtres['prix_min'] ?? null, fn ($q, $min) =>
                $q->where('prix', '>=', (int) $min))
            ->when($filtres['prix_max'] ?? null, fn ($q, $max) =>
                $q->where('prix', '<=', (int) $max))
            ->when($filtres['recherche'] ?? null, fn ($q, $mot) =>
                $q->where('nom', 'like', "%{$mot}%"));
    }

    /* ----- Helpers ----- */

    public function prixFormate(): string
    {
        return number_format($this->prix, 0, ',', ' ') . ' FCFA';
    }

    // Listes centralisées : mêmes valeurs pour l'admin et les filtres du front
    public static function matieres(): array
    {
        return ['Cuir', 'Cuir végétal', 'Tissu wax', 'Raphia', 'Toile', 'Mixte'];
    }

    public static function occasions(): array
    {
        return ['Cadeau', 'Bureau', 'Soirée', 'Cérémonie', 'Quotidien'];
    }

    /* ----- Lien WhatsApp pré-rempli (tunnel du brief : site -> WhatsApp) ----- */

    public function lienWhatsApp(): string
    {
        $numero = config('services.whatsapp.numero');
        $message = rawurlencode(
            "Bonjour Blac Joyaux ! Je suis intéressée par le sac « {$this->nom} » à {$this->prixFormate()}. Est-il disponible ?"
        );

        return "https://wa.me/{$numero}?text={$message}";
    }
}
