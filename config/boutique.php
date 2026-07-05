<?php

return [
    // Numéro WhatsApp de la marque (format international sans +, ex: 2250701020304)
    'whatsapp' => env('BOUTIQUE_WHATSAPP', '2250700000000'),

    // Message affiché partout pour rassurer (frein n°1 du brief : le manque d'information)
    'delai_livraison' => env('BOUTIQUE_DELAI', 'Livraison à Abidjan sous 1 à 3 jours'),

    'quartiers' => [
        'Cocody', 'Plateau', 'Marcory', 'Treichville', 'Yopougon',
        'Abobo', 'Adjamé', 'Koumassi', 'Port-Bouët', 'Bingerville', 'Autre',
    ],
];
