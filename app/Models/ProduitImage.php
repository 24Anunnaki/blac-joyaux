<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduitImage extends Model
{
    protected $table = 'produit_images';

    protected $fillable = ['product_id', 'url', 'principale', 'ordre'];

    protected $casts = ['principale' => 'boolean'];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'product_id');
    }

    // La colonne url stocke le chemin relatif dans storage/app/public
    public function lien(): string
    {
        return asset('storage/' . $this->url);
    }
}
