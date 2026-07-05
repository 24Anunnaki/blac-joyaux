@extends('boutique.layout')

@section('titre', $produit->nom . ' — ' . $produit->prixFormate() . ' — Blac Joyaux')
@section('meta_description', Str::limit('Sac ' . $produit->nom . ' de la collection ' . $produit->categorie->nom . '. ' . strip_tags($produit->description ?? 'Maroquinerie artisanale made in Côte d\'Ivoire.'), 155))

{{-- Données structurées Product + FAQ : livrable SEO / AI-First du brief --}}
@section('jsonld')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $produit->nom }}",
    "description": "{{ Str::limit(strip_tags($produit->description ?? ''), 200) }}",
    "brand": { "@type": "Brand", "name": "Blac Joyaux" },
    @if ($produit->imagePrincipale)
    "image": "{{ $produit->imagePrincipale->lien() }}",
    @endif
    "material": "{{ $produit->matiere }}",
    "offers": {
        "@type": "Offer",
        "priceCurrency": "XOF",
        "price": "{{ $produit->prix }}",
        "availability": "{{ $produit->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "areaServed": "Abidjan, Côte d'Ivoire"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "Quel est le délai de livraison à Abidjan ?",
            "acceptedAnswer": { "@type": "Answer", "text": "Votre sac est livré à Abidjan sous 1 à 3 jours ouvrés après confirmation de la commande." }
        },
        {
            "@type": "Question",
            "name": "Quels moyens de paiement acceptez-vous ?",
            "acceptedAnswer": { "@type": "Answer", "text": "Orange Money, MTN Mobile Money, Wave, ou paiement en espèces à la livraison." }
        },
        {
            "@type": "Question",
            "name": "Le sac {{ $produit->nom }} est-il fait en Côte d'Ivoire ?",
            "acceptedAnswer": { "@type": "Answer", "text": "Oui, chaque sac Blac Joyaux est confectionné à la main par nos artisans à Abidjan." }
        },
        {
            "@type": "Question",
            "name": "Puis-je l'offrir en cadeau ?",
            "acceptedAnswer": { "@type": "Answer", "text": "Oui : au moment de la commande, choisissez l'option emballage cadeau avec un message personnalisé, et faites livrer directement à la personne de votre choix." }
        }
    ]
}
</script>
@endsection

@section('contenu')

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;" class="fiche-produit">
    <style>
        @media (max-width: 780px) { .fiche-produit { grid-template-columns: 1fr !important; } }
        .galerie-fiche .principale { aspect-ratio: 4/5; background: var(--blanc-chaud); border: 1px solid var(--ligne); display: flex; align-items: center; justify-content: center; color: var(--gris); overflow: hidden; }
        .galerie-fiche .principale img { width: 100%; height: 100%; object-fit: cover; }
        .galerie-fiche .miniatures { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
        .galerie-fiche .miniatures img { width: 72px; height: 72px; object-fit: cover; border: 1px solid var(--ligne); cursor: pointer; }
        .galerie-fiche .miniatures img:hover { border-color: var(--or); }
        .detail dt { font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris); margin-top: 14px; }
        .detail dd { margin: 3px 0 0; }
        .faq details { border-bottom: 1px solid var(--ligne); padding: 13px 0; }
        .faq summary { cursor: pointer; font-weight: 500; }
        .faq p { margin-top: 8px; color: var(--gris); font-size: 15px; }
    </style>

    <div class="galerie-fiche">
        <div class="principale">
            @if ($produit->images->isNotEmpty())
                <img id="image-principale" src="{{ ($produit->imagePrincipale ?? $produit->images->first())->lien() }}" alt="Sac {{ $produit->nom }} — Blac Joyaux">
            @else
                Photo à venir
            @endif
        </div>
        @if ($produit->images->count() > 1)
            <div class="miniatures">
                @foreach ($produit->images as $image)
                    <img src="{{ $image->lien() }}" alt="Sac {{ $produit->nom }} — vue {{ $loop->iteration }}"
                         onclick="document.getElementById('image-principale').src = this.src">
                @endforeach
            </div>
        @endif
    </div>

    <div>
        <div class="fil">{{ $produit->categorie->nom }}</div>
        <h1 style="font-size: clamp(30px, 4.5vw, 40px);">{{ $produit->nom }}</h1>
        <p style="font-size: 24px; margin: 8px 0 4px;">{{ $produit->prixFormate() }}</p>
        <p style="font-size: 14px; color: {{ $produit->stock > 0 ? 'var(--ok)' : 'var(--danger)' }};">
            {{ $produit->stock > 0 ? '✓ Disponible — ' . config('boutique.delai_livraison') : 'Momentanément épuisé — contactez-nous sur WhatsApp' }}
        </p>

        @if ($produit->description)
            <p style="margin-top: 16px;">{{ $produit->description }}</p>
        @endif

        <form method="POST" action="{{ route('boutique.panier.ajouter', $produit) }}" style="margin-top: 22px;">
            @csrf
            @if ($produit->couleurs->isNotEmpty())
                <div class="champ">
                    <label for="couleur">Couleur</label>
                    <select id="couleur" name="couleur">
                        @foreach ($produit->couleurs as $couleur)
                            <option value="{{ $couleur->nom }}">{{ $couleur->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-noir" style="flex: 1;" {{ $produit->stock < 1 ? 'disabled' : '' }}>
                    Ajouter au panier
                </button>
            </div>
        </form>

        {{-- Tunnel du brief : le doute se lève en conversation --}}
        <a class="btn btn-whatsapp btn-large" style="margin-top: 12px;"
           href="{{ $lienWhatsapp }}" target="_blank" rel="noopener">
            Poser une question sur WhatsApp
        </a>

        <dl class="detail">
            @if ($produit->dimensions)
                <dt>Dimensions</dt><dd>{{ $produit->dimensions }}</dd>
            @endif
            @if ($produit->matiere)
                <dt>Matière</dt><dd>{{ $produit->matiere }}</dd>
            @endif
            @if ($produit->occasion)
                <dt>Parfait pour</dt><dd>{{ $produit->occasion }}</dd>
            @endif
            <dt>Fabrication</dt><dd>Fait main à Abidjan, Côte d'Ivoire</dd>
        </dl>

        @if ($produit->histoire)
            <div style="margin-top: 24px; padding: 20px; background: var(--noir); color: #EDE6DA;">
                <div class="fil" style="color: var(--or-clair);">L'histoire de ce modèle</div>
                <p style="font-family: 'Cormorant Garamond', serif; font-size: 19px; line-height: 1.5;">{{ $produit->histoire }}</p>
            </div>
        @endif

        <div class="faq" style="margin-top: 26px;">
            <h2 style="font-size: 22px; margin-bottom: 6px;">Questions fréquentes</h2>
            <details>
                <summary>Quel est le délai de livraison ?</summary>
                <p>Votre sac est livré à Abidjan sous 1 à 3 jours ouvrés. Le livreur vous appelle avant de passer.</p>
            </details>
            <details>
                <summary>Comment payer ?</summary>
                <p>Orange Money, MTN MoMo, Wave — ou en espèces à la réception de votre sac.</p>
            </details>
            <details>
                <summary>Puis-je l'offrir en cadeau ?</summary>
                <p>Oui ! Choisissez l'option cadeau à la commande : emballage élégant, message personnalisé, et livraison à l'adresse de votre choix.</p>
            </details>
            <details>
                <summary>Où voir le sac en vrai ?</summary>
                <p>Au showroom Blac Joyaux de Cocody Palmeraie, à Abidjan. Écrivez-nous sur WhatsApp pour convenir d'un passage.</p>
            </details>
        </div>
    </div>
</div>

@if ($similaires->isNotEmpty())
    <section style="margin-top: 52px;">
        <h2 style="font-size: 26px; margin-bottom: 18px;">Dans la même collection</h2>
        <div class="grille-produits">
            @foreach ($similaires as $autre)
                <a class="carte-produit" href="{{ route('boutique.produit', $autre->slug) }}">
                    <div class="visuel">
                        @if ($autre->imagePrincipale)
                            <img src="{{ $autre->imagePrincipale->lien() }}" alt="Sac {{ $autre->nom }} — Blac Joyaux">
                        @else
                            Photo à venir
                        @endif
                    </div>
                    <div class="nom">{{ $autre->nom }}</div>
                    <div class="prix">{{ $autre->prixFormate() }}</div>
                </a>
            @endforeach
        </div>
    </section>
@endif

@endsection
