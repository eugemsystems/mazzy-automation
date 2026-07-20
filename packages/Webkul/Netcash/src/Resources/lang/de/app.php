<?php

return [
    'description' => 'Sicher bezahlen mit Netcash Pay Now',
    'title' => 'Netcash',

    'redirect' => [
        'click-if-not-redirected' => 'Klicken Sie hier, um fortzufahren',
        'please-wait' => 'Bitte warten Sie, während wir Sie zum Zahlungsanbieter weiterleiten...',
        'redirect-message' => 'Wenn Sie nicht automatisch weitergeleitet werden, klicken Sie auf die Schaltfläche unten.',
        'redirecting' => 'Weiterleitung zu Netcash...',
        'redirecting-to-payment' => 'Weiterleitung zu Netcash Pay Now',
        'secure-payment' => 'Sicheres Zahlungsgateway',
    ],

    'response' => [
        'cart-not-found' => 'Warenkorb nicht gefunden. Bitte versuchen Sie es erneut.',
        'invalid-transaction' => 'Ungültige Transaktion. Bitte versuchen Sie es erneut.',
        'order-creation-failed' => 'Bestellung konnte nicht erstellt werden. Bitte kontaktieren Sie den Support.',
        'payment-failed' => 'Zahlung fehlgeschlagen oder abgebrochen. Bitte versuchen Sie es erneut.',
        'payment-success' => 'Zahlung erfolgreich abgeschlossen!',
        'provide-credentials' => 'Bitte konfigurieren Sie den Netcash Pay Now Service-Schlüssel im Admin-Panel.',
    ],
];
