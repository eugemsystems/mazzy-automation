<?php

return [
    'description' => 'Betaal veilig via Netcash Pay Now',
    'title' => 'Netcash',

    'redirect' => [
        'click-if-not-redirected' => 'Klik hier om door te gaan',
        'please-wait' => 'Even geduld, we leiden u door naar de betaalgateway...',
        'redirect-message' => 'Als u niet automatisch wordt doorgeleid, klik dan op de knop hieronder.',
        'redirecting' => 'Doorleiden naar Netcash...',
        'redirecting-to-payment' => 'Doorleiden naar Netcash Pay Now',
        'secure-payment' => 'Beveiligde betaalgateway',
    ],

    'response' => [
        'cart-not-found' => 'Winkelwagen niet gevonden. Probeer het opnieuw.',
        'invalid-transaction' => 'Ongeldige transactie. Probeer het opnieuw.',
        'order-creation-failed' => 'Bestelling aanmaken mislukt. Neem contact op met de support.',
        'payment-failed' => 'Betaling mislukt of geannuleerd. Probeer het opnieuw.',
        'payment-success' => 'Betaling succesvol voltooid!',
        'provide-credentials' => 'Configureer de Netcash Pay Now Service Key in het adminpaneel.',
    ],
];
