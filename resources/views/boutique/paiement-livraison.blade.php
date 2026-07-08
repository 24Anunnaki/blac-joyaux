@extends('boutique.layout')

@section('titre', 'Paiement & Livraison — Blac Joyaux')

@section('contenu')

<div style="max-width: 780px; margin: 0 auto; padding: 40px 0 80px;">

    <div class="fil">Aide</div>
    <h1 style="font-size: clamp(30px, 4.5vw, 44px); margin-bottom: 40px;">Paiement & Livraison</h1>

    {{-- PAIEMENT --}}
    <section style="margin-bottom: 48px;">
        <h2 style="font-size: 22px; letter-spacing: .04em; margin-bottom: 14px; color: var(--or);">Paiement</h2>
        <p style="margin-bottom: 14px;">Vous pouvez régler votre commande de deux façons :</p>
        <ul style="padding-left: 20px; line-height: 1.9;">
            <li><strong>Mobile Money</strong> — Orange Money, MTN Money ou Wave, au moment de la validation de votre commande.</li>
            <li><strong>Paiement à la livraison</strong> — réglez en espèces directement à réception de votre colis.</li>
        </ul>
        <p style="margin-top: 14px;">Pour toute question sur le paiement, contactez-nous directement sur
            <a href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener" style="color: var(--or); text-decoration: underline;">WhatsApp</a>.
        </p>
    </section>

    {{-- LIVRAISON --}}
    <section style="margin-bottom: 48px;">
        <h2 style="font-size: 22px; letter-spacing: .04em; margin-bottom: 14px; color: var(--or);">Livraison</h2>
        <p style="margin-bottom: 14px;">{{ config('boutique.delai_livraison') }}.</p>
        <ul style="padding-left: 20px; line-height: 1.9;">
            <li><strong>Zone de livraison</strong> — Abidjan et environs (nous consulter pour l'intérieur du pays).</li>
            <li><strong>Retrait en showroom</strong> — possible sur rendez-vous, à Cocody Palmeraie.</li>
            <li><strong>Suivi de commande</strong> — vous êtes contacté(e) par WhatsApp dès l'expédition de votre colis.</li>
        </ul>
    </section>

    {{-- CONTACT --}}
    <section>
        <h2 style="font-size: 22px; letter-spacing: .04em; margin-bottom: 14px; color: var(--or);">Une question ?</h2>
        <p style="margin-bottom: 18px;">Notre équipe est disponible pour vous accompagner avant, pendant et après votre commande.</p>
        <a class="btn btn-whatsapp" href="https://wa.me/{{ config('boutique.whatsapp') }}" target="_blank" rel="noopener">
            Nous écrire sur WhatsApp
        </a>
    </section>

</div>

@endsection
