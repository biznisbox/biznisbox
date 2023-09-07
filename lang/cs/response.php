<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Úspěšně jste se přihlásili',
        'failed' => 'Přihlášení se nezdařilo',
    ],
    'logout' => [
        'success' => 'Odhlášení bylo úspěšné',
        'failed' => 'Odhlášení se nezdařilo',
    ],
    'auth' => [
        'failed' => 'Ověření se nezdařilo',
    ],
    'reset' => [
        'success' => 'Obnovení hesla bylo úspěšné',
        'failed' => 'Obnovení hesla se nezdařilo',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produkt nebyl nalezen',
        'get_success' => 'Produkty úspěšně načteny',
        'get_failed' => 'Produkty nelze načíst',
        'create_success' => 'Produkt byl úspěšně vytvořen',
        'create_failed' => 'Produkt nelze vytvořit',
        'update_success' => 'Produkt byl úspěšně aktualizován',
        'update_failed' => 'Produkt nemohl být aktualizován',
        'delete_success' => 'Produkt byl úspěšně odstraněn',
        'delete_failed' => 'Produkt nelze odstranit',
    ],

    // Vendor responses
    'vendor' => [
        'not_found' => 'Dodavatel nebyl nalezen',
        'get_success' => 'Prodejci úspěšně načteni',
        'get_failed' => 'Prodejci nelze načíst',
        'create_success' => 'Dodavatel byl úspěšně vytvořen',
        'create_failed' => 'Dodavatel nemohl být vytvořen',
        'update_success' => 'Dodavatel byl úspěšně aktualizován',
        'update_failed' => 'Dodavatel nemohl být aktualizován',
        'delete_success' => 'Dodavatel byl úspěšně odstraněn',
        'delete_failed' => 'Dodavatel nemohl být odstraněn',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transakce nenalezena',
        'get_success' => 'Transakce úspěšně načteny',
        'get_failed' => 'Transakce nelze načíst',
        'create_success' => 'Transakce byla úspěšně vytvořena',
        'create_failed' => 'Transakci nelze vytvořit',
        'update_success' => 'Transakce byla úspěšně aktualizována',
        'update_failed' => 'Transakci nelze aktualizovat',
        'delete_success' => 'Transakce byla úspěšně odstraněna',
        'delete_failed' => 'Transakci nelze odstranit',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Účty úspěšně načteny',
        'get_failed' => 'Účty nelze načíst',
        'not_found' => 'Účet nebyl nalezen',
        'create_success' => 'Účet byl úspěšně vytvořen',
        'create_error' => 'Účet nelze vytvořit',
        'update_success' => 'Účet byl úspěšně aktualizován',
        'update_error' => 'Účet nelze aktualizovat',
        'delete_success' => 'Účet byl úspěšně odstraněn',
        'delete_error' => 'Účet nelze odstranit',
        'get_success' => 'Účet byl úspěšně načten',
        'get_error' => 'Účet nelze načíst',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Faktura byla úspěšně načtena',
        'get_error' => 'Faktura nemohla být načtena',
        'create_success' => 'Faktura byla úspěšně vytvořena',
        'create_error' => 'Faktura nemohla být vytvořena',
        'update_success' => 'Faktura byla úspěšně aktualizována',
        'update_error' => 'Fakturaci nelze aktualizovat',
        'delete_success' => 'Faktura byla úspěšně odstraněna',
        'delete_error' => 'Faktura nemohla být úspěšně odstraněna',
    ],

    //Customer responses
    'customer' => [
        'get_success' => 'Zákazníci úspěšně načteni',
        'get_failed' => 'Zákazníky nelze načíst',
        'not_found' => 'Zákazník nebyl nalezen',
        'create_failed' => 'Zákazníka nelze vytvořit',
        'create_success' => 'Zákazník byl úspěšně vytvořen',
        'update_success' => 'Zákazník byl úspěšně aktualizován',
        'delete_success' => 'Zákazník byl úspěšně odstraněn',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumenty byly úspěšně načteny',
        'get_error' => 'Dokumenty nelze načíst',
        'not_found' => 'Doklad nebyl nalezen',
        'create_failed' => 'Doklad nelze vytvořit',
        'create_success' => 'Dokument byl úspěšně vytvořen',
        'update_success' => 'Dokument byl úspěšně aktualizován',
        'update_error' => 'Dokument nelze aktualizovat',
        'delete_failed' => 'Doklad nemohl být úspěšně odstraněn',
        'delete_success' => 'Doklad byl úspěšně odstraněn',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Soubor byl úspěšně načten',
        'get_error' => 'Soubor nelze načíst',
        'not_found' => 'Soubor nebyl nalezen',
        'create_failed' => 'Soubor nelze vytvořit',
        'create_success' => 'Soubor byl úspěšně vytvořen',
        'update_success' => 'Soubor byl úspěšně aktualizován',
        'update_failed' => 'Soubor nelze aktualizovat',
        'delete_failed' => 'Soubor nemohl být úspěšně odstraněn',
        'delete_success' => 'Soubor byl úspěšně odstraněn',
        'get_success_folder' => 'Složka úspěšně načtena',
        'get_error_folder' => 'Složky nelze načíst',
        'not_found_folder' => 'Složka nebyla nalezena',
        'create_failed_folder' => 'Složku nelze vytvořit',
        'create_success_folder' => 'Složka byla úspěšně vytvořena',
        'update_success_folder' => 'Složka byla úspěšně aktualizována',
        'update_failed_folder' => 'Složku nelze aktualizovat',
        'delete_failed_folder' => 'Složku nelze úspěšně odstranit',
        'delete_success_folder' => 'Složka byla úspěšně smazána',
    ],

    //Estimate responses
    'estimate' => [
        'get_success' => 'Odhady úspěšně načteny',
        'get_failed' => 'Odhady nelze načíst',
        'not_found' => 'Odhad nebyl nalezen',
        'create_failed' => 'Odhad nelze vytvořit',
        'create_success' => 'Odhad byl úspěšně vytvořen',
        'convert_success' => 'Odhad byl úspěšně převeden na fakturu',
        'update_success' => 'Odhad byl úspěšně aktualizován',
        'delete_success' => 'Odhad byl úspěšně odstraněn',
        'delete_failed' => 'Odhad nelze odstranit',
        'update_failed' => 'Odhad nemohl být aktualizován',
        'share_success' => 'Odhad byl úspěšně sdílen',
        'share_failed' => 'Odhad nelze sdílet',
        'accept_reject_success' => 'Odhad byl úspěšně odmítnut',
        'send_success' => 'Odhad byl úspěšně odeslán',
        'send_failed' => 'Odhad nelze odeslat',
        'pdf_failed' => 'Generování PDF selhalo',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Faktury úspěšně načteny',
        'get_failed' => 'Faktury nelze načíst',
        'not_found' => 'Faktura nebyla nalezena',
        'create_failed' => 'Faktura nemohla být vytvořena',
        'create_success' => 'Faktura byla úspěšně vytvořena',
        'delete_success' => 'Faktura byla úspěšně odstraněna',
        'update_success' => 'Faktura byla úspěšně aktualizována',
        'share_success' => 'Faktura byla úspěšně sdílena',
        'share_failed' => 'Odhad nelze sdílet',
        'send_success' => 'Faktura byla úspěšně odeslána',
        'pdf_failed' => 'Generování PDF selhalo',
        'send_failed' => 'Faktura nemohla být odeslána',
        'update_failed' => 'Fakturu nelze aktualizovat',
        'delete_failed' => 'Faktura nemohla být odstraněna',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe není k dispozici',
        'already_paid' => 'Faktura již byla zaplacena',
        'invalid_key' => 'Neplatný klíč API',
        'not_found' => 'Platba nebyla nalezena',
        'success' => 'Platba byla úspěšná',
        'failed' => 'Platba se nezdařila',
        'paypal_not_available' => 'PayPal není k dispozici',
        'invoice' => 'Faktura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Uživatel nebyl nalezen',
        'update_success' => 'Uživatel byl úspěšně aktualizován',
        'password_updated' => 'Heslo bylo úspěšně aktualizováno',
        'password_not_match' => 'Heslo se neshoduje',
        'password_empty' => 'Pole pro heslo je prázdné',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Země je povinná',
        'not_enabled' => 'Otevřené bankovnictví není povoleno',
        'not_found' => 'Otevřené bankovnictví nenalezeno',
        'id_required' => 'ID je povinné',
        'not_provided_infos' => 'Neposkytnuté informace',
        'requisition_success' => 'Požadavek byl úspěšný',
        'requisition_failed' => 'Požadavek se nezdařil',
        'session_id_required' => 'Je vyžadováno ID relace',
        'account_id_required' => 'Je vyžadováno ID účtu',
    ],

    'calendar' => [
        'get_success' => 'Událost úspěšně načtena',
        'get_error' => 'Událost nelze načíst',
        'not_found' => 'Událost nebyla nalezena',
        'create_failed' => 'Událost nemohla být vytvořena',
        'create_success' => 'Událost byla úspěšně vytvořena',
        'update_success' => 'Událost byla úspěšně aktualizována',
        'update_failed' => 'Událost nemohla být aktualizována',
        'delete_failed' => 'Událost nemohla být úspěšně odstraněna',
        'delete_success' => 'Událost byla úspěšně odstraněna',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Faktura',
    ],

    'dashboard' => [
        'income' => 'Výnosy',
        'expense' => 'Výdaje',
    ],

    'months' => [
        'january' => 'Leden',
        'february' => 'únor',
        'march' => 'Březen',
        'april' => 'duben',
        'may' => 'Maj',
        'june' => 'Červen',
        'july' => 'červenec',
        'august' => 'Srpen',
        'september' => 'Září',
        'october' => 'Říjen',
        'november' => 'Listopad',
        'december' => 'prosinec',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Role nebyla nalezena',
            'create_failed' => 'Role nemohla být vytvořena',
            'create_success' => 'Role byla úspěšně vytvořena',
            'update_success' => 'Role byla úspěšně aktualizována',
            'delete_success' => 'Role byla úspěšně smazána',
            'delete_failed' => 'Role nemohla být odstraněna',
            'super_admin_cannot_be_created' => 'Super administrátorská role nemůže být vytvořena',
            'super_admin_cannot_be_updated' => 'Super administrátorská role nemůže být aktualizována',
            'super_admin_cannot_be_deleted' => 'Super administrátorská role nemůže být odstraněna',
        ],
        'company_logo' => [
            'upload_success' => 'Logo společnosti bylo úspěšně nahráno',
            'upload_failed' => 'Logo společnosti nelze nahrát',
            'remove_success' => 'Logo společnosti bylo úspěšně odstraněno',
            'remove_failed' => 'Logo společnosti nelze odstranit',
        ],
        'settings' => [
            'update_success' => 'Nastavení bylo úspěšně aktualizováno',
            'update_failed' => 'Nastavení nelze aktualizovat',
        ],
        'currency' => [
            'not_found' => 'Měnu nelze nalézt',
            'create_failed' => 'Měnu nelze vytvořit',
            'create_success' => 'Měna byla úspěšně vytvořena',
            'update_success' => 'Měna byla úspěšně aktualizována',
            'delete_success' => 'Měna byla úspěšně smazána',
            'delete_failed' => 'Měnu nelze odstranit',
            'rates_updated' => 'Sazby byly úspěšně aktualizovány',
        ],
        'taxes' => [
            'not_found' => 'Daň nebyla nalezena',
            'create_failed' => 'Daň nelze vytvořit',
            'create_success' => 'Daň byla úspěšně vytvořena',
            'update_success' => 'Daň byla úspěšně aktualizována',
            'delete_success' => 'Daň byla úspěšně odstraněna',
            'delete_failed' => 'Daň nelze odstranit',
        ],

        'user' => [
            'not_found' => 'Uživatel nebyl nalezen',
            'create_failed' => 'Uživatele nelze vytvořit',
            'create_success' => 'Uživatel byl úspěšně vytvořen',
            'update_success' => 'Uživatel byl úspěšně aktualizován',
            'update_failed' => 'Uživatele nelze aktualizovat',
            'delete_success' => 'Uživatel byl úspěšně odstraněn',
            'delete_failed' => 'Uživatele nelze odstranit',
            'password_reset_success' => 'Heslo bylo úspěšně obnoveno',
            'password_reset_failed' => 'Heslo nelze obnovit',
            'delete_failed_self_account' => 'Nemůžete smazat svůj vlastní účet',
        ],
    ],
];
