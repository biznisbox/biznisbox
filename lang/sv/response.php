<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Du har loggat in',
        'failed' => 'Inloggning misslyckades',
    ],
    'logout' => [
        'success' => 'Du har loggat ut',
        'failed' => 'Utloggning misslyckades',
    ],
    'auth' => [
        'failed' => 'Autentisering misslyckades',
    ],
    'reset' => [
        'success' => 'Lösenord återställt framgångsrikt',
        'failed' => 'Lösenordsåterställning misslyckades',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produkten hittades inte',
        'get_success' => 'Produkter har hämtats',
        'get_failed' => 'Produkter kunde inte hämtas',
        'create_success' => 'Produkten har skapats',
        'create_failed' => 'En produkt kunde inte skapas',
        'update_success' => 'Produkten har uppdaterats',
        'update_failed' => 'En produkt kunde inte uppdateras',
        'delete_success' => 'Produkten har tagits bort',
        'delete_failed' => 'En produkt kunde inte raderas',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Partner hittades inte',
        'get_success' => 'Partners har hämtats',
        'get_failed' => 'Partners kunde inte hämtas',
        'create_success' => 'Partnern har skapats',
        'create_failed' => 'En partner kunde inte skapas',
        'update_success' => 'Partnern har uppdaterats',
        'update_failed' => 'En partner kunde inte uppdateras',
        'delete_success' => 'Partnern har tagits bort',
        'delete_failed' => 'En partner kunde inte raderas',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaktionen hittades inte',
        'get_success' => 'Transaktioner har hämtats',
        'get_failed' => 'Transaktioner kunde inte hämtas',
        'create_success' => 'Transaktionen har skapats',
        'create_failed' => 'En transaktion kunde inte skapas',
        'update_success' => 'Transaktionen har uppdaterats',
        'update_failed' => 'En transaktion kunde inte uppdateras',
        'delete_success' => 'Transaktionen har tagits bort',
        'delete_failed' => 'En transaktion kunde inte tas bort',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Konton har hämtats',
        'get_failed' => 'Konton kunde inte hämtas',
        'not_found' => 'Kontot kunde inte hittas',
        'create_success' => 'Kontot har skapats',
        'create_error' => 'Kontot kunde inte skapas',
        'update_success' => 'Kontot har uppdaterats',
        'update_error' => 'Kontot kunde inte uppdateras',
        'delete_success' => 'Kontot har tagits bort',
        'delete_error' => 'Kontot kunde inte tas bort',
        'get_success' => 'Kontot har hämtats',
        'get_error' => 'Kontot kunde inte hämtas',
        'delete_default_account' => 'Standardkontot kan inte tas bort',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Bill har hämtats',
        'get_error' => 'Bill kunde inte hämtas',
        'create_success' => 'Fakturan har skapats',
        'create_error' => 'Fakturan kunde inte skapas',
        'update_success' => 'Bill har uppdaterats',
        'update_error' => 'Fakturan kunde inte uppdateras',
        'delete_success' => 'Fakturan har tagits bort',
        'delete_error' => 'Fakturan kunde inte raderas',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumenten har hämtats',
        'get_error' => 'Dokumenten kunde inte hämtas',
        'not_found' => 'Dokumentet kunde inte hittas',
        'create_failed' => 'Dokumentet kunde inte skapas',
        'create_success' => 'Dokumentet har skapats',
        'update_success' => 'Dokumentet har uppdaterats',
        'update_error' => 'Dokumentet kunde inte uppdateras',
        'delete_failed' => 'Dokumentet kunde inte raderas',
        'delete_success' => 'Dokumentet har tagits bort',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'Anställd hittades inte',
        'get_success' => 'Anställda har hämtats',
        'get_failed' => 'Anställda kunde inte hämtas',
        'create_success' => 'Anställd har skapats',
        'create_failed' => 'En anställd kunde inte skapas',
        'update_success' => 'Anställd har uppdaterats',
        'update_failed' => 'En anställd kunde inte uppdateras',
        'delete_success' => 'Anställd har tagits bort',
        'delete_failed' => 'En anställd kunde inte tas bort',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Filen har hämtats',
        'get_error' => 'Filen kunde inte hämtas',
        'not_found' => 'Filen kunde inte hittas',
        'create_failed' => 'Filen kunde inte skapas',
        'create_success' => 'Filen har skapats',
        'update_success' => 'Filen har uppdaterats',
        'update_failed' => 'Filen kunde inte uppdateras',
        'delete_failed' => 'Filen kunde inte raderas',
        'delete_success' => 'Filen har tagits bort',
        'get_success_folder' => 'Mappen har hämtats',
        'get_error_folder' => 'Mappar kunde inte hämtas',
        'not_found_folder' => 'Mappen kunde inte hittas',
        'create_failed_folder' => 'Mappen kunde inte skapas',
        'create_success_folder' => 'Mappen har skapats',
        'update_success_folder' => 'Mappen har uppdaterats',
        'update_failed_folder' => 'Mappen kunde inte uppdateras',
        'delete_failed_folder' => 'Mappen kunde inte raderas',
        'delete_success_folder' => 'Mappen har tagits bort',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Offerter har hämtats',
        'get_failed' => 'Offerter kunde inte hämtas',
        'not_found' => 'Offert kunde inte hittas',
        'create_failed' => 'Offert kunde inte skapas',
        'create_success' => 'Offert har skapats',
        'convert_success' => 'Offerten har konverterats till faktura',
        'update_success' => 'Offerten har uppdaterats',
        'delete_success' => 'Offerten har tagits bort',
        'delete_failed' => 'Offert kunde inte tas bort',
        'update_failed' => 'Offerten kunde inte uppdateras',
        'share_success' => 'Offerten delades framgångsrikt',
        'share_failed' => 'Offert kunde inte delas',
        'accept_reject_success' => 'Offerten avvisades',
        'send_success' => 'Offert har skickats',
        'send_failed' => 'Offert kunde inte skickas',
        'pdf_failed' => 'PDF-generering misslyckades',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Fakturor har hämtats',
        'get_failed' => 'Fakturor kunde inte hämtas',
        'not_found' => 'Fakturan kunde inte hittas',
        'create_failed' => 'Fakturan kunde inte skapas',
        'create_success' => 'Fakturan har skapats',
        'delete_success' => 'Fakturan har tagits bort',
        'update_success' => 'Fakturan har uppdaterats',
        'share_success' => 'Fakturan delades framgångsrikt',
        'share_failed' => 'Offert kunde inte delas',
        'send_success' => 'Fakturan har skickats',
        'pdf_failed' => 'PDF-generering misslyckades',
        'send_failed' => 'Fakturan kunde inte skickas',
        'update_failed' => 'Fakturan kunde inte uppdateras',
        'delete_failed' => 'Fakturan kunde inte tas bort',
        'transaction_success' => 'Transaktionen har lagts till',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Rand är inte tillgänglig',
        'already_paid' => 'Fakturan har redan betalats',
        'invalid_key' => 'Ogiltig API-nyckel',
        'not_found' => 'Betalningen kunde inte hittas',
        'success' => 'Betalningen slutfördes',
        'failed' => 'Betalningen misslyckades',
        'paypal_not_available' => 'PayPal är inte tillgängligt',
        'invoice' => 'Faktura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Användaren kunde inte hittas',
        'update_success' => 'Användaren har uppdaterats',
        'password_updated' => 'Lösenordet har uppdaterats',
        'password_not_match' => 'Lösenordet matchar inte',
        'password_empty' => 'Lösenordsfältet är tomt',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Land krävs',
        'not_enabled' => 'Open Banking är inte aktiverat',
        'not_found' => 'Open Banking hittades inte',
        'id_required' => 'ID krävs',
        'not_provided_infos' => 'Ej angiven information',
        'requisition_success' => 'Rekvisition lyckades',
        'requisition_failed' => 'Begäran misslyckades',
        'session_id_required' => 'Sessions-ID krävs',
        'account_id_required' => 'Konto ID krävs',
    ],

    'calendar' => [
        'get_success' => 'Händelsen har hämtats',
        'get_error' => 'Händelsen kunde inte hämtas',
        'not_found' => 'Händelsen kunde inte hittas',
        'create_failed' => 'Händelsen kunde inte skapas',
        'create_success' => 'Händelsen har skapats',
        'update_success' => 'Händelsen har uppdaterats',
        'update_failed' => 'Händelsen kunde inte uppdateras',
        'delete_failed' => 'Händelsen kunde inte raderas',
        'delete_success' => 'Händelsen har tagits bort',
    ],
    'department' => [
        'get_success' => 'Avdelningen har hämtats',
        'get_error' => 'Avdelningen kunde inte hämtas',
        'not_found' => 'Avdelningen kunde inte hittas',
        'create_failed' => 'Avdelningen kunde inte skapas',
        'create_success' => 'Avdelningen har skapats',
        'update_success' => 'Avdelningen har uppdaterats',
        'update_failed' => 'Avdelningen kunde inte uppdateras',
        'delete_failed' => 'Avdelningen kunde inte raderas',
        'delete_success' => 'Avdelningen har tagits bort',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Faktura',
    ],

    'dashboard' => [
        'income' => 'Inkomst',
        'expense' => 'Utgift',
    ],

    'months' => [
        'january' => 'Januari',
        'february' => 'Februari',
        'march' => 'Mars',
        'april' => 'april',
        'may' => 'Maj',
        'june' => 'Juni',
        'july' => 'Juli',
        'august' => 'Augusti',
        'september' => 'september',
        'october' => 'Oktober',
        'november' => 'november',
        'december' => 'december',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rollen kunde inte hittas',
            'create_failed' => 'Rollen kunde inte skapas',
            'create_success' => 'Rollen har skapats',
            'update_success' => 'Rollen har uppdaterats',
            'delete_success' => 'Rollen har tagits bort',
            'delete_failed' => 'Rollen kunde inte raderas',
            'super_admin_cannot_be_created' => 'Super Admin roll kan inte skapas',
            'super_admin_cannot_be_updated' => 'Super Admin roll kan inte uppdateras',
            'super_admin_cannot_be_deleted' => 'Super Admin roll kan inte tas bort',
        ],
        'company_logo' => [
            'upload_success' => 'Företagslogotypen har laddats upp',
            'upload_failed' => 'Företagslogotypen kunde inte laddas upp',
            'remove_success' => 'Företagslogotypen har tagits bort',
            'remove_failed' => 'Företagslogotypen kunde inte tas bort',
        ],
        'settings' => [
            'update_success' => 'Inställningarna har uppdaterats',
            'update_failed' => 'Inställningarna kunde inte uppdateras',
        ],
        'currency' => [
            'not_found' => 'Valutan kunde inte hittas',
            'create_failed' => 'Valutan kunde inte skapas',
            'create_success' => 'Valutan har skapats',
            'update_success' => 'Valutan har uppdaterats',
            'delete_success' => 'Valutan har tagits bort',
            'delete_failed' => 'Valutan kunde inte tas bort',
            'rates_updated' => 'Priserna har uppdaterats',
        ],
        'taxes' => [
            'not_found' => 'Kunde inte hitta moms',
            'create_failed' => 'Skatt kunde inte skapas',
            'create_success' => 'Moms har skapats',
            'update_success' => 'Skatt har uppdaterats',
            'delete_success' => 'Moms har tagits bort',
            'delete_failed' => 'Momsen kunde inte tas bort',
        ],

        'user' => [
            'not_found' => 'Användaren kunde inte hittas',
            'create_failed' => 'Användaren kunde inte skapas',
            'create_success' => 'Användaren har skapats',
            'update_success' => 'Användaren har uppdaterats',
            'update_failed' => 'Användaren kunde inte uppdateras',
            'delete_success' => 'Användaren har tagits bort',
            'delete_failed' => 'Användaren kunde inte tas bort',
            'password_reset_success' => 'Lösenordet har återställts',
            'password_reset_failed' => 'Lösenordet kunde inte återställas',
            'delete_failed_self_account' => 'Du kan inte ta bort ditt eget konto',
        ],
    ],
    'memory_used' => 'Använt minne',
    'memory_available' => 'Tillgängligt minne',
    'disk_used' => 'Disk som används',
    'disk_available' => 'Disk tillgänglig',
];
