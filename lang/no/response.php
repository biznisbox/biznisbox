<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Du har nå logget inn',
        'failed' => 'Påloggingen mislyktes',
    ],
    'logout' => [
        'success' => 'Du har logget ut',
        'failed' => 'Utlogging mislyktes',
    ],
    'auth' => [
        'failed' => 'Godkjenning mislyktes',
    ],
    'reset' => [
        'success' => 'Tilbakestilling av passord vellykket',
        'failed' => 'Nullstilling av passord mislyktes',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produktet ble ikke funnet',
        'get_success' => 'Produkter hentet vellykket',
        'get_failed' => 'Produkter kunne ikke hentes',
        'create_success' => 'Produkt opprettet',
        'create_failed' => 'Et produkt kan ikke opprettes',
        'update_success' => 'Produktet er oppdatert',
        'update_failed' => 'Kan ikke oppdatere et produkt',
        'delete_success' => 'Produkt vellykket slettet',
        'delete_failed' => 'Et produkt kan ikke slettes',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Finner ikke partner',
        'get_success' => 'Partnere hentet vellykket',
        'get_failed' => 'Partnere kunne ikke hentes',
        'create_success' => 'Partneren er opprettet',
        'create_failed' => 'Kan ikke opprette en partner',
        'update_success' => 'Partneren ble oppdatert',
        'update_failed' => 'Kan ikke oppdatere partner',
        'delete_success' => 'Partner slettet',
        'delete_failed' => 'En partner kan ikke slettes',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaksjonen ikke funnet',
        'get_success' => 'Vellykket henting av transaksjoner',
        'get_failed' => 'Transaksjonene kunne ikke gjenopprettes',
        'create_success' => 'Transaksjon opprettet',
        'create_failed' => 'En transaksjon kunne ikke opprettes',
        'update_success' => 'Transaksjonen er oppdatert',
        'update_failed' => 'Kan ikke oppdatere en transaksjon',
        'delete_success' => 'Transaksjonen ble slettet',
        'delete_failed' => 'En transaksjon kunne ikke slettes',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Vellykket henting av kontoer',
        'get_failed' => 'Kontoer kunne ikke hentes',
        'not_found' => 'Fant ikke kontoen',
        'create_success' => 'Kontoen ble opprettet',
        'create_error' => 'Kontoen kunne ikke opprettes',
        'update_success' => 'Kontoen er oppdatert',
        'update_error' => 'Kontoen kunne ikke oppdateres',
        'delete_success' => 'Kontoen ble slettet',
        'delete_error' => 'Kontoen kan ikke slettes',
        'get_success' => 'Kontoen er hentet',
        'get_error' => 'Kontoen kunne ikke hentes',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Bill hentet med hell',
        'get_error' => 'Bill kunne ikke hentes',
        'create_success' => 'Regning opprettet',
        'create_error' => 'Regning kan ikke opprettes',
        'update_success' => 'Regningen ble oppdatert',
        'update_error' => 'Regningen kunne ikke oppdateres',
        'delete_success' => 'Faktura ble slettet',
        'delete_error' => 'Regningen kunne ikke slettes',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumenter vellykket hentet',
        'get_error' => 'Dokumenter kunne ikke hentes',
        'not_found' => 'Dokument ble ikke funnet',
        'create_failed' => 'Dokument kunne ikke opprettes',
        'create_success' => 'Dokumentet ble opprettet',
        'update_success' => 'Dokumentet ble oppdatert',
        'update_error' => 'Dokumentet kunne ikke oppdateres',
        'delete_failed' => 'Dokumentet kunne ikke slettes',
        'delete_success' => 'Dokumentet ble slettet',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Filen ble hentet',
        'get_error' => 'Filen kunne ikke hentes',
        'not_found' => 'Filen ble ikke funnet',
        'create_failed' => 'Filen kunne ikke opprettes',
        'create_success' => 'Filen ble opprettet',
        'update_success' => 'Filen ble vellykket oppdatert',
        'update_failed' => 'Filen kunne ikke oppdateres',
        'delete_failed' => 'Filen kunne ikke slettes',
        'delete_success' => 'Filen ble slettet',
        'get_success_folder' => 'Mappen ble hentet',
        'get_error_folder' => 'Mapper kunne ikke hentes',
        'not_found_folder' => 'Mappe ble ikke funnet',
        'create_failed_folder' => 'Mappe kunne ikke opprettes',
        'create_success_folder' => 'Mappen ble opprettet',
        'update_success_folder' => 'Mappen ble oppdatert',
        'update_failed_folder' => 'Mappe kunne ikke oppdateres',
        'delete_failed_folder' => 'Mappen kunne ikke slettes',
        'delete_success_folder' => 'Mappen ble slettet',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Vellykket henting av tilbud',
        'get_failed' => 'Tilbud kunne ikke hentes',
        'not_found' => 'Tilbud ble ikke funnet',
        'create_failed' => 'Tilbud kunne ikke opprettes',
        'create_success' => 'Tilbud er opprettet',
        'convert_success' => 'Tilbudet ble konvertert til faktura vellykket',
        'update_success' => 'Tilbudet ble oppdatert',
        'delete_success' => 'Tilbudet ble slettet',
        'delete_failed' => 'Tilbud kan ikke slettes',
        'update_failed' => 'Tilbud kunne ikke oppdateres',
        'share_success' => 'Tilbud ble delt',
        'share_failed' => 'Tilbud kunne ikke deles',
        'accept_reject_success' => 'Tilbud ble avvist',
        'send_success' => 'Tilbudet ble sendt',
        'send_failed' => 'Tilbud kunne ikke sendes',
        'pdf_failed' => 'Generering av PDF mislyktes',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Fakturaer hentet hell',
        'get_failed' => 'Fakturaer kunne ikke hentes',
        'not_found' => 'Faktura ble ikke funnet',
        'create_failed' => 'Faktura kunne ikke opprettes',
        'create_success' => 'Faktura ble opprettet',
        'delete_success' => 'Fakturaen ble slettet',
        'update_success' => 'Fakturaen ble oppdatert',
        'share_success' => 'Faktura ble delt',
        'share_failed' => 'Tilbud kunne ikke deles',
        'send_success' => 'Faktura ble sendt',
        'pdf_failed' => 'Generering av PDF mislyktes',
        'send_failed' => 'Faktura kunne ikke sendes',
        'update_failed' => 'Fakturaen kunne ikke oppdateres',
        'delete_failed' => 'Fakturaen kunne ikke slettes',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe er ikke tilgjengelig',
        'already_paid' => 'Fakturaen ble allerede betalt',
        'invalid_key' => 'Ugyldig API-nøkkel',
        'not_found' => 'Betalingen ble ikke funnet',
        'success' => 'Betalingen var vellykket',
        'failed' => 'Betaling mislyktes',
        'paypal_not_available' => 'Paypal ikke tilgjengelig',
        'invoice' => 'Faktura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Bruker ble ikke funnet',
        'update_success' => 'Oppdatering av bruker var vellykket',
        'password_updated' => 'Passordet ble oppdatert',
        'password_not_match' => 'Passordet stemmer ikke',
        'password_empty' => 'Passordfeltet er tomt',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Land er påkrevd',
        'not_enabled' => 'Åpne Banking er ikke aktivert',
        'not_found' => 'Åpne bank ikke funnet',
        'id_required' => 'ID kreves',
        'not_provided_infos' => 'Ikke oppgitt informasjon',
        'requisition_success' => 'Rekvisisjon suksess',
        'requisition_failed' => 'Rekvisisjon mislyktes',
        'session_id_required' => 'Økt-ID er påkrevd',
        'account_id_required' => 'Konto-ID kreves',
    ],

    'calendar' => [
        'get_success' => 'Hendelsen er vellykket hentet',
        'get_error' => 'Hendelsen kunne ikke hentes',
        'not_found' => 'Hendelsen ble ikke funnet',
        'create_failed' => 'Hendelsen kunne ikke opprettes',
        'create_success' => 'Hendelsen ble opprettet',
        'update_success' => 'Hendelsen ble oppdatert',
        'update_failed' => 'Hendelsen kunne ikke oppdateres',
        'delete_failed' => 'Hendelsen kunne ikke slettes',
        'delete_success' => 'Hendelsen ble slettet',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Faktura',
    ],

    'dashboard' => [
        'income' => 'Inntekt',
        'expense' => 'Utgift',
    ],

    'months' => [
        'january' => 'Januar',
        'february' => 'Februar',
        'march' => 'Mars',
        'april' => 'april',
        'may' => 'Maj',
        'june' => 'Juni',
        'july' => 'Juli',
        'august' => 'august',
        'september' => 'september',
        'october' => 'oktober',
        'november' => 'november',
        'december' => 'Desember',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rollen ble ikke funnet',
            'create_failed' => 'Rollen kunne ikke opprettes',
            'create_success' => 'Rollen ble opprettet',
            'update_success' => 'Rollen ble oppdatert',
            'delete_success' => 'Rollen ble slettet',
            'delete_failed' => 'Rollen kunne ikke slettes',
            'super_admin_cannot_be_created' => 'Super Admin-rolle kan ikke opprettes',
            'super_admin_cannot_be_updated' => 'Super Admin-rollen kan ikke oppdateres',
            'super_admin_cannot_be_deleted' => 'Super Admin-rollen kan ikke slettes',
        ],
        'company_logo' => [
            'upload_success' => 'Bedriftslogo ble lastet opp',
            'upload_failed' => 'Bedriftslogo kunne ikke lastes opp',
            'remove_success' => 'Bedriftslogo ble fjernet',
            'remove_failed' => 'Bedriftslogo kunne ikke fjernes',
        ],
        'settings' => [
            'update_success' => 'Innstillingene ble oppdatert',
            'update_failed' => 'Innstillingene kunne ikke oppdateres',
        ],
        'currency' => [
            'not_found' => 'Valuta ble ikke funnet',
            'create_failed' => 'Valuta kunne ikke opprettes',
            'create_success' => 'Valuta ble opprettet',
            'update_success' => 'Valuta ble oppdatert',
            'delete_success' => 'Valuta ble slettet',
            'delete_failed' => 'Valuta kan ikke slettes',
            'rates_updated' => 'Rentesatser ble oppdatert',
        ],
        'taxes' => [
            'not_found' => 'Avgift ble ikke funnet',
            'create_failed' => 'Avgift kunne ikke opprettes',
            'create_success' => 'Avgift ble opprettet',
            'update_success' => 'Oppdatering av avgift vellykket',
            'delete_success' => 'Avgift ble slettet',
            'delete_failed' => 'Avgift kunne ikke slettes',
        ],

        'user' => [
            'not_found' => 'Bruker ble ikke funnet',
            'create_failed' => 'Brukeren kunne ikke opprettes',
            'create_success' => 'Vellykket opprettelse av bruker',
            'update_success' => 'Oppdatering av bruker var vellykket',
            'update_failed' => 'Brukeren kunne ikke oppdateres',
            'delete_success' => 'Vellykket sletting av bruker',
            'delete_failed' => 'Brukeren kunne ikke slettes',
            'password_reset_success' => 'Passordet ble tilbakestilt',
            'password_reset_failed' => 'Passord kunne ikke tilbakestilles',
            'delete_failed_self_account' => 'Du kan ikke slette din egen konto',
        ],
    ],
];
