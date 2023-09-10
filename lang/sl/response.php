<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Prijava je bila uspešna',
        'failed' => 'Prijava ni bila uspešna',
    ],
    'logout' => [
        'success' => 'Odjava je bila uspešna',
        'failed' => 'Odjava ni bila uspešna',
    ],
    'auth' => [
        'failed' => 'Avtentikacija ni bila uspešna',
    ],
    'reset' => [
        'success' => 'Uspešno ponastavljeno geslo',
        'failed' => 'Ponastavitev gesla ni bila uspešna',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Izdelek ni bil najden',
        'get_success' => 'Izdelek je bil uspešno pridobljen',
        'get_failed' => 'Izdelka ni bilo mogoče pridobiti',
        'create_success' => 'Izdelek je bil uspešno ustvarjen',
        'create_failed' => 'Izdelka ni bilo mogoče ustvariti',
        'update_success' => 'Izdelek je bil uspešno posodobljen',
        'update_failed' => 'Izdelka ni bilo mogoče posodobiti',
        'delete_success' => 'Izdelek je bil uspešno izbrisan',
        'delete_failed' => 'Izdelka ni bilo mogoče izbrisati',
    ],

    // Vendor responses
    'vendor' => [
        'not_found' => 'Prodajalec ni bil najden',
        'get_success' => 'Prodajalec je bil uspešno pridobljen',
        'get_failed' => 'Prodajalca ni bilo mogoče pridobiti',
        'create_success' => 'Prodajalec je bil uspešno ustvarjen',
        'create_failed' => 'Prodajalca ni bilo mogoče ustvariti',
        'update_success' => 'Prodajalec je bil uspešno posodobljen',
        'update_failed' => 'Prodajalca ni bilo mogoče posodobiti',
        'delete_success' => 'Prodajalec je bil uspešno izbrisan',
        'delete_failed' => 'Prodajalca ni bilo mogoče izbrisati',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transakcija ni možno najti',
        'get_success' => 'Transakcija je bila uspešno pridobljena',
        'get_failed' => 'Transakcije ni bilo mogoče pridobiti',
        'create_success' => 'Transakcija je bila uspešno ustvarjena',
        'create_failed' => 'Transakcije ni bilo mogoče ustvariti',
        'update_success' => 'Transakcija je bila uspešno posodobljena',
        'update_failed' => 'Transakcije ni bilo mogoče posodobiti',
        'delete_success' => 'Transakcija je bila uspešno izbrisana',
        'delete_failed' => 'Transakcije ni bilo mogoče izbrisati',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Račun je bil uspešno pridobljen',
        'get_failed' => 'Računa ni bilo mogoče pridobiti',
        'not_found' => 'Računa ni bilo mogoče najti',
        'create_success' => 'Račun je bil uspešno ustvarjen',
        'create_error' => 'Računa ni bilo mogoče ustvariti',
        'update_success' => 'Račun je bil uspešno posodobljen',
        'update_error' => 'Računa ni bilo mogoče posodobiti',
        'delete_success' => 'Račun je bil uspešno izbrisan',
        'delete_error' => 'Računa ni bilo mogoče izbrisati',
        'get_success' => 'Račun je bil uspešno pridobljen',
        'get_error' => 'Računa ni bilo mogoče pridobiti',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Račun je bil uspešno pridobljen',
        'get_error' => 'Računa ni bilo mogoče pridobiti',
        'create_success' => 'Račun je bil uspešno ustvarjen',
        'create_error' => 'Računa ni bilo mogoče ustvariti',
        'update_success' => 'Račun je bil uspešno posodobljen',
        'update_error' => 'Računa ni bilo mogoče posodobiti',
        'delete_success' => 'Račun je bil uspešno izbrisan',
        'delete_error' => 'Računa ni bilo mogoče izbrisati',
    ],

    //Customer responses
    'customer' => [
        'get_success' => 'Kupec je bil uspešno pridobljen',
        'get_failed' => 'Kupca ni bilo mogoče pridobiti',
        'not_found' => 'Kupeca ni bilo mogoče najti',
        'create_failed' => 'Kupec ni bil ustvarjen',
        'create_success' => 'Kupec je bil uspešno ustvarjen',
        'update_success' => '   Kupec je bil uspešno posodobljen',
        'delete_success' => 'Kupec je bil uspešno izbrisan',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokument je bil uspešno pridobljen',
        'get_error' => 'Dokumenta ni bilo mogoče pridobiti',
        'not_found' => 'Dokumenta ni mogoče najti',
        'create_failed' => 'Dokument ni bil ustvarjen',
        'create_success' => 'Dokument je bil uspešno ustvarjen',
        'update_success' => 'Dokument je bil uspešno posodobljen',
        'update_error' => 'Dokument ni bil posodobljen',
        'delete_failed' => 'Dokumenta ni bilo mogoče izbrisati',
        'delete_success' => 'Dokument je bil uspešno izbrisan',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Datoteka pridobljena uspešno',
        'get_error' => 'Datoteke ni bilo mogoče pridobiti',
        'not_found' => 'Datoteke ni mogoče najti',
        'create_failed' => 'Datoteke ni mogoče ustvariti',
        'create_success' => 'Datoteka uspešno ustvarjena',
        'update_success' => 'Datoteka uspešno posodobljena',
        'update_failed' => 'Datoteke ni bilo mogoče posodobiti',
        'delete_failed' => 'Datoteke ni bilo mogoče izbrisati',
        'delete_success' => 'Datoteka uspešno izbrisana',
        'get_success_folder' => 'Mapa uspešno pridobljena',
        'get_error_folder' => 'Mape ni bilo mogoče pridobiti',
        'not_found_folder' => 'Mape ni bilo mogoče najti',
        'create_failed_folder' => 'Mape ni bilo mogoče ustvariti',
        'create_success_folder' => 'Mapa uspešno ustvarjena',
        'update_success_folder' => 'Mapa uspešno posodobljena',
        'update_failed_folder' => 'Mape ni bilo mogoče posodobiti',
        'delete_failed_folder' => 'Mape ni bilo mogoče izbrisati',
        'delete_success_folder' => 'Mapa uspešno izbrisana',
    ],

    //Estimate responses
    'estimate' => [
        'get_success' => 'Predračun je bil uspešno pridobljen',
        'get_failed' => 'Predračuna ni bilo mogoče pridobiti',
        'not_found' => 'Predračuna ni bilo mogoče najti',
        'create_failed' => 'Predračun ni bil ustvarjen',
        'create_success' => 'Predračun je bil uspešno ustvarjen',
        'convert_success' => 'Predračun je bil uspešno pretvorjen v račun',
        'update_success' => 'Predračun je bil uspešno posodobljen',
        'delete_success' => 'Predračun je bil uspešno izbrisan',
        'delete_failed' => 'Predračuna ni bilo mogoče izbrisati',
        'update_failed' => 'Predračuna ni bilo mogoče posodobiti',
        'share_success' => 'Predračun je bil uspešno posredovan',
        'share_failed' => 'Predračuna ni mogoče deliti',
        'accept_reject_success' => 'Predračun je bil uspešno sprejet/zavrnjen',
        'send_success' => 'Predračun je bil uspešno poslan',
        'send_failed' => 'Predračuna ni bilo mogoče poslati',
        'pdf_failed' => 'Ustvarjanje PDF datoteke ni bilo uspešno',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Račun je bil uspešno pridobljen',
        'get_failed' => 'Računa ni bilo mogoče pridobiti',
        'not_found' => 'Računa ni bilo mogoče najti',
        'create_failed' => 'Račun ni bil ustvarjen',
        'create_success' => 'Račun je bil uspešno ustvarjen',
        'delete_success' => 'Račun je bil uspešno izbrisan',
        'update_success' => 'Račun je bil uspešno posodobljen',
        'share_success' => 'Račun je bil uspešno posredovan',
        'share_failed' => 'Predračuna ni mogoče deliti',
        'send_success' => 'Račun je bil uspešno poslan',
        'pdf_failed' => 'Ustvarjanje PDF datoteke ni bilo uspešno',
        'send_failed' => 'Računa ni bilo mogoče poslati',
        'update_failed' => 'Računa ni bilo mogoče posodobiti',
        'delete_failed' => 'Računa ni bilo mogoče izbrisati',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe ni na voljo',
        'already_paid' => 'Plačilo je bilo že opravljeno',
        'invalid_key' => 'Neveljaven ključ',
        'not_found' => 'Plačila ni bilo mogoče najti',
        'success' => 'Plačilo je bilo uspešno opravljeno',
        'failed' => 'Plačila ni bilo mogoče opraviti',
        'paypal_not_available' => 'PayPal ni na voljo',
        'invoice' => 'Račun',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Uporabnika ni bilo mogoče najti',
        'update_success' => 'Uporabnik je bil uspešno posodobljen',
        'password_updated' => 'Geslo je bilo uspešno posodobljeno',
        'password_not_match' => 'Geslo se ne ujema',
        'password_empty' => 'Polje za geslo ne sme biti prazno',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Država je obvezna',
        'not_enabled' => 'Open Banking ni omogočen',
        'not_found' => 'Open Banking ni na voljo',
        'id_required' => 'ID je obvezen',
        'not_provided_infos' => 'Informacije niso bile posredovane',
        'requisition_success' => 'Zahteva je bila uspešna',
        'requisition_failed' => 'Zahteva je bila neuspešna',
        'session_id_required' => 'ID seje je obvezen',
        'account_id_required' => 'ID računa je obvezen',
    ],

    'calendar' => [
        'get_success' => 'Dogodek uspešno pridobljen',
        'get_error' => 'Dogodka ni bilo mogoče pridobiti',
        'not_found' => 'Dogodka ni mogoče najti',
        'create_failed' => 'Dogodka ni mogoče ustvariti',
        'create_success' => 'Dogodek uspešno ustvarjen',
        'update_success' => 'Dogodek uspešno posodobljena',
        'update_failed' => 'Dogodka ni bilo mogoče posodobiti',
        'delete_failed' => 'Dogodka ni bilo mogoče izbrisati',
        'delete_success' => 'Dogodek uspešno izbrisana',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Račun',
    ],

    'dashboard' => [
        'income' => 'Prihodek',
        'expense' => 'Odhodek',
    ],

    'months' => [
        'january' => 'Januar',
        'february' => 'Februar',
        'march' => 'Marec',
        'april' => 'April',
        'may' => 'Maj',
        'june' => 'Junij',
        'july' => 'Julij',
        'august' => 'Avgust',
        'september' => 'September',
        'october' => 'Oktober',
        'november' => 'November',
        'december' => 'December',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Vloge ni bilo mogoče najti',
            'create_failed' => 'Vloga ni bila ustvarjena',
            'create_success' => 'Vloga je bila uspešno ustvarjena',
            'update_success' => 'Vloga je bila uspešno posodobljena',
            'delete_success' => 'Vloga je bila uspešno izbrisana',
            'delete_failed' => 'Vloge ni bilo mogoče izbrisati',
            'super_admin_cannot_be_created' => 'Super Admin vloge ni mogoče ustvariti',
            'super_admin_cannot_be_updated' => 'Super Admin vloge ni mogoče posodobiti',
            'super_admin_cannot_be_deleted' => 'Super Admin vloge ni mogoče izbrisati',
        ],
        'company_logo' => [
            'upload_success' => 'Logotip podjetja je bil uspešno naložen',
            'upload_failed' => 'Logotipa podjetja ni bilo mogoče naložiti',
            'remove_success' => 'Logotip podjetja je bil uspešno odstranjen',
            'remove_failed' => 'Logotipa podjetja ni bilo mogoče odstraniti',
        ],
        'settings' => [
            'update_success' => 'Nastavitve so bile uspešno posodobljene',
            'update_failed' => 'Nastavitve ni bilo mogoče posodobiti',
        ],
        'currency' => [
            'not_found' => 'Valute ni bilo mogoče najti',
            'create_failed' => 'Valuta ni bila ustvarjena',
            'create_success' => 'Valuta je bila uspešno ustvarjena',
            'update_success' => 'Valuta je bila uspešno posodobljena',
            'delete_success' => 'Valuta je bila uspešno izbrisana',
            'delete_failed' => 'Valute ni bilo mogoče izbrisati',
            'rates_updated' => 'Tečaji so bili uspešno posodobljeni',
        ],
        'taxes' => [
            'not_found' => 'Davčne stopnje ni bilo mogoče najti',
            'create_failed' => 'Davčna stopnja ni bila ustvarjena',
            'create_success' => 'Davčna stopnja je bila uspešno ustvarjena',
            'update_success' => 'Davčna stopnja je bila uspešno posodobljena',
            'delete_success' => 'Davčna stopnja je bila uspešno izbrisana',
            'delete_failed' => 'Davčne stopnje ni bilo mogoče izbrisati',
        ],

        'user' => [
            'not_found' => 'Uporabnika ni bilo mogoče najti',
            'create_failed' => 'Uporabnika ni bilo mogoče ustvariti',
            'create_success' => 'Uporabnik je bil uspešno ustvarjen',
            'update_success' => 'Uporabnik je bil uspešno posodobljen',
            'update_failed' => 'Uporabnika ni bilo mogoče posodobiti',
            'delete_success' => 'Uporabnik uspešno izbrisan',
            'delete_failed' => 'Uporabnika ni bilo mogoče izbrisati',
            'password_reset_success' => 'Geslo je ospešno ponastavljeno',
            'password_reset_failed' => 'Gesla ni bilo mogoče ponastaviti',
            'delete_failed_self_account' => 'Ne morate izbrisati lastnega računa',
        ],
    ],
];
