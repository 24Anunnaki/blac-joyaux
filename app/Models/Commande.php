<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $table = 'commandes';

    protected $fillable = [
        'client_id', 'reference', 'statut', 'total',
        'mode_paiement', 'mode_livraison', 'adresse_livraison', 'delai',
        'emballage_cadeau', 'message_cadeau',
    ];

    protected $casts = ['emballage_cadeau' => 'boolean'];

    public const STATUTS = [
        'en_attente' => 'En attente',
        'payee' => 'Payée',
        'en_livraison' => 'En livraison',
        'livree' => 'Livrée',
        'annulee' => 'Annulée',
    ];

    public const PAIEMENTS = [
        'orange_money' => 'Orange Money',
        'mtn_money' => 'MTN MoMo',
        'wave' => 'Wave',
        'especes' => 'Espèces à la livraison',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommande::class, 'commande_id');
    }

    public function totalFormate(): string
    {
        return number_format($this->total, 0, ',', ' ') . ' FCFA';
    }

    public function statutLisible(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function paiementLisible(): string
    {
        return self::PAIEMENTS[$this->mode_paiement] ?? ($this->mode_paiement ?? '—');
    }
}
