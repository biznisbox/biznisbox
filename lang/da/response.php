<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Du har logget ind',
        'failed' => 'Login mislykkedes',
    ],
    'logout' => [
        'success' => 'Du er nu logget ud',
        'failed' => 'Log af mislykkedes',
    ],
    'auth' => [
        'failed' => 'Godkendelse mislykkedes',
    ],
    'reset' => [
        'success' => 'Adgangskode nulstillet',
        'failed' => 'Nulstilling af adgangskode mislykkedes',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produktet blev ikke fundet',
        'get_success' => 'Produkter hentet',
        'get_failed' => 'Produkter kunne ikke hentes',
        'create_success' => 'Produktet blev oprettet',
        'create_failed' => 'Et produkt kunne ikke oprettes',
        'update_success' => 'Produkt opdateret',
        'update_failed' => 'Et produkt kunne ikke opdateres',
        'delete_success' => 'Produktet blev slettet',
        'delete_failed' => 'Et produkt kunne ikke slettes',
    ],

    // Vendor responses
    'vendor' => [
        'not_found' => 'Leverandør ikke fundet',
        'get_success' => 'Forhandlere blev hentet',
        'get_failed' => 'Forhandlere kunne ikke hentes',
        'create_success' => 'Leverandør oprettet',
        'create_failed' => 'En sælger kunne ikke oprettes',
        'update_success' => 'Leverandør opdateret',
        'update_failed' => 'En sælger kunne ikke opdateres',
        'delete_success' => 'Leverandør slettet',
        'delete_failed' => 'En sælger kunne ikke slettes',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaktionen blev ikke fundet',
        'get_success' => 'Transaktioner hentet',
        'get_failed' => 'Transaktioner kunne ikke hentes',
        'create_success' => 'Transaktionen er oprettet',
        'create_failed' => 'En transaktion kunne ikke oprettes',
        'update_success' => 'Transaktionen blev opdateret',
        'update_failed' => 'En transaktion kunne ikke opdateres',
        'delete_success' => 'Transaktionen blev slettet',
        'delete_failed' => 'En transaktion kunne ikke slettes',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Konti hentet',
        'get_failed' => 'Konti kunne ikke hentes',
        'not_found' => 'Konto kunne ikke findes',
        'create_success' => 'Konto oprettet med succes',
        'create_error' => 'Konto kunne ikke oprettes',
        'update_success' => 'Konto opdateret',
        'update_error' => 'Konto kunne ikke opdateres',
        'delete_success' => 'Konto slettet',
        'delete_error' => 'Konto kunne ikke slettes',
        'get_success' => 'Kontoen blev hentet',
        'get_error' => 'Konto kunne ikke hentes',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Bill hentet succesfuldt',
        'get_error' => 'Faktura kunne ikke hentes',
        'create_success' => 'Faktura oprettet',
        'create_error' => 'Faktura kunne ikke oprettes',
        'update_success' => 'Bill opdateret',
        'update_error' => 'Regningen kunne ikke opdateres',
        'delete_success' => 'Faktura slettet',
        'delete_error' => 'Faktura kunne ikke slettes',
    ],

    //Customer responses
    'customer' => [
        'get_success' => 'Kunder hentet',
        'get_failed' => 'Kunder kunne ikke hentes',
        'not_found' => 'Kunden kunne ikke findes',
        'create_failed' => 'Kunde kunne ikke oprettes',
        'create_success' => 'Kunden blev oprettet',
        'update_success' => 'Kunden blev opdateret',
        'delete_success' => 'Kunde slettet',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumenter hentet',
        'get_error' => 'Dokumenter kunne ikke hentes',
        'not_found' => 'Dokumentet kunne ikke findes',
        'create_failed' => 'Dokumentet kunne ikke oprettes',
        'create_success' => 'Dokumentet blev oprettet',
        'update_success' => 'Dokumentet blev opdateret',
        'update_error' => 'Dokumentet kunne ikke opdateres',
        'delete_failed' => 'Dokumentet kunne ikke slettes',
        'delete_success' => 'Dokument slettet',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Fil hentet',
        'get_error' => 'Filen kunne ikke hentes',
        'not_found' => 'Filen kunne ikke findes',
        'create_failed' => 'Filen kunne ikke oprettes',
        'create_success' => 'Filen blev oprettet',
        'update_success' => 'Filen blev opdateret',
        'update_failed' => 'Filen kunne ikke opdateres',
        'delete_failed' => 'Filen kunne ikke slettes',
        'delete_success' => 'Filen blev slettet',
        'get_success_folder' => 'Mappen er hentet',
        'get_error_folder' => 'Mapper kunne ikke hentes',
        'not_found_folder' => 'Mappen kunne ikke findes',
        'create_failed_folder' => 'Mappen kunne ikke oprettes',
        'create_success_folder' => 'Mappen blev oprettet',
        'update_success_folder' => 'Mappen blev opdateret',
        'update_failed_folder' => 'Mappen kunne ikke opdateres',
        'delete_failed_folder' => 'Mappen kunne ikke slettes',
        'delete_success_folder' => 'Mappen blev slettet',
    ],

    //Estimate responses
    'estimate' => [
        'get_success' => 'Estimater hentet med succes',
        'get_failed' => 'Estimater kunne ikke hentes',
        'not_found' => 'Estimeret kunne ikke findes',
        'create_failed' => 'Estimeret kunne ikke oprettes',
        'create_success' => 'Estimatet blev oprettet',
        'convert_success' => 'Estimeret blev konverteret til faktura',
        'update_success' => 'Estimatet blev opdateret',
        'delete_success' => 'Estimatet blev slettet',
        'delete_failed' => 'Estimeret kunne ikke slettes',
        'update_failed' => 'Estimeret kunne ikke opdateres',
        'share_success' => 'Estimatet blev delt',
        'share_failed' => 'Estimeret kunne ikke deles',
        'accept_reject_success' => 'Estimatet blev afvist',
        'send_success' => 'Estimering blev sendt',
        'send_failed' => 'Estimeret kunne ikke sendes',
        'pdf_failed' => 'Generering af PDF mislykkedes',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Fakturaer hentet med succes',
        'get_failed' => 'Fakturaer kunne ikke hentes',
        'not_found' => 'Faktura kunne ikke findes',
        'create_failed' => 'Faktura kunne ikke oprettes',
        'create_success' => 'Faktura blev oprettet',
        'delete_success' => 'Faktura blev slettet',
        'update_success' => 'Faktura blev opdateret',
        'share_success' => 'Faktura blev delt med succes',
        'share_failed' => 'Estimeret kunne ikke deles',
        'send_success' => 'Faktura blev sendt',
        'pdf_failed' => 'Generering af PDF mislykkedes',
        'send_failed' => 'Faktura kunne ikke sendes',
        'update_failed' => 'Faktura kunne ikke opdateres',
        'delete_failed' => 'Faktura kunne ikke slettes',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe er ikke tilgængelig',
        'already_paid' => 'Faktura er allerede betalt',
        'invalid_key' => 'Ugyldig API-nøgle',
        'not_found' => 'Betaling kunne ikke findes',
        'success' => 'Betaling blev gennemført',
        'failed' => 'Betaling mislykkedes',
        'paypal_not_available' => 'PayPal er ikke tilgængelig',
        'invoice' => 'Faktura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Brugeren kunne ikke findes',
        'update_success' => 'Bruger blev opdateret',
        'password_updated' => 'Adgangskoden blev opdateret',
        'password_not_match' => 'Adgangskoden matcher ikke',
        'password_empty' => 'Adgangskodefeltet er tomt',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Land er påkrævet',
        'not_enabled' => 'Open Banking er ikke aktiveret',
        'not_found' => 'Open Banking ikke fundet',
        'id_required' => 'ID er påkrævet',
        'not_provided_infos' => 'Ikke oplyst info',
        'requisition_success' => 'Rekvisition succes',
        'requisition_failed' => 'Kravet mislykkedes',
        'session_id_required' => 'Session ID er påkrævet',
        'account_id_required' => 'Konto ID er påkrævet',
    ],

    'calendar' => [
        'get_success' => 'Begivenhed blev hentet',
        'get_error' => 'Begivenheden kunne ikke hentes',
        'not_found' => 'Begivenheden kunne ikke findes',
        'create_failed' => 'Begivenheden kunne ikke oprettes',
        'create_success' => 'Begivenheden blev oprettet',
        'update_success' => 'Begivenheden blev opdateret',
        'update_failed' => 'Begivenheden kunne ikke opdateres',
        'delete_failed' => 'Begivenheden kunne ikke slettes',
        'delete_success' => 'Begivenhed slettet',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Faktura',
    ],

    'dashboard' => [
        'income' => 'Indkomst',
        'expense' => 'Udgifter',
    ],

    'months' => [
        'january' => 'Januar',
        'february' => 'Februar',
        'march' => 'Marts',
        'april' => 'April',
        'may' => 'Maj',
        'june' => 'Juni',
        'july' => 'Juli',
        'august' => 'August',
        'september' => 'September',
        'october' => 'Oktober',
        'november' => 'November',
        'december' => 'December',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rolle kunne ikke findes',
            'create_failed' => 'Rolle kunne ikke oprettes',
            'create_success' => 'Rolle blev oprettet',
            'update_success' => 'Rollen blev opdateret',
            'delete_success' => 'Rollen blev slettet',
            'delete_failed' => 'Rolle kunne ikke slettes',
            'super_admin_cannot_be_created' => 'Super Admin rolle kan ikke oprettes',
            'super_admin_cannot_be_updated' => 'Super Admin rolle kan ikke opdateres',
            'super_admin_cannot_be_deleted' => 'Super Admin rolle kan ikke slettes',
        ],
        'company_logo' => [
            'upload_success' => 'Virksomhedslogo blev uploadet',
            'upload_failed' => 'Virksomhedslogo kunne ikke uploades',
            'remove_success' => 'Virksomhedslogo blev fjernet',
            'remove_failed' => 'Virksomhedslogo kunne ikke fjernes',
        ],
        'settings' => [
            'update_success' => 'Indstillinger blev opdateret',
            'update_failed' => 'Indstillinger kunne ikke opdateres',
        ],
        'currency' => [
            'not_found' => 'Valuta kunne ikke findes',
            'create_failed' => 'Valuta kunne ikke oprettes',
            'create_success' => 'Valuta blev oprettet',
            'update_success' => 'Valuta blev opdateret',
            'delete_success' => 'Valuta blev slettet',
            'delete_failed' => 'Valuta kunne ikke slettes',
            'rates_updated' => 'Priser blev opdateret',
        ],
        'taxes' => [
            'not_found' => 'Moms kunne ikke findes',
            'create_failed' => 'Moms kunne ikke oprettes',
            'create_success' => 'Moms blev oprettet',
            'update_success' => 'Moms blev opdateret',
            'delete_success' => 'Moms blev slettet',
            'delete_failed' => 'Moms kunne ikke slettes',
        ],

        'user' => [
            'not_found' => 'Brugeren kunne ikke findes',
            'create_failed' => 'Brugeren kunne ikke oprettes',
            'create_success' => 'Brugeren blev oprettet',
            'update_success' => 'Bruger blev opdateret',
            'update_failed' => 'Brugeren kunne ikke opdateres',
            'delete_success' => 'Brugeren blev slettet',
            'delete_failed' => 'Brugeren kunne ikke slettes',
            'password_reset_success' => 'Adgangskoden blev nulstillet',
            'password_reset_failed' => 'Adgangskoden kunne ikke nulstilles',
            'delete_failed_self_account' => 'Du kan ikke slette din egen konto',
        ],
    ],
];
