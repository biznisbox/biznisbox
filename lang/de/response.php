<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Sie haben sich erfolgreich angemeldet',
        'failed' => 'Login fehlgeschlagen',
    ],
    'logout' => [
        'success' => 'Sie haben sich erfolgreich abgemeldet',
        'failed' => 'Abmeldung fehlgeschlagen',
    ],
    'auth' => [
        'failed' => 'Authentifizierung fehlgeschlagen',
    ],
    'reset' => [
        'success' => 'Passwort erfolgreich zurückgesetzt',
        'failed' => 'Passwort zurücksetzen fehlgeschlagen',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produkt nicht gefunden',
        'get_success' => 'Produkte erfolgreich abgerufen',
        'get_failed' => 'Produkte konnten nicht abgerufen werden',
        'create_success' => 'Produkt erfolgreich erstellt',
        'create_failed' => 'Ein Produkt konnte nicht erstellt werden',
        'update_success' => 'Produkt erfolgreich aktualisiert',
        'update_failed' => 'Ein Produkt konnte nicht aktualisiert werden',
        'delete_success' => 'Produkt erfolgreich gelöscht',
        'delete_failed' => 'Ein Produkt konnte nicht gelöscht werden',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Partner nicht gefunden',
        'get_success' => 'Partner erfolgreich abgerufen',
        'get_failed' => 'Partner konnten nicht abgerufen werden',
        'create_success' => 'Partner erfolgreich erstellt',
        'create_failed' => 'Ein Partner konnte nicht erstellt werden',
        'update_success' => 'Partner erfolgreich aktualisiert',
        'update_failed' => 'Ein Partner konnte nicht aktualisiert werden',
        'delete_success' => 'Partner erfolgreich gelöscht',
        'delete_failed' => 'Ein Partner konnte nicht gelöscht werden',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaktion nicht gefunden',
        'get_success' => 'Transaktionen erfolgreich abgerufen',
        'get_failed' => 'Transaktionen konnten nicht abgerufen werden',
        'create_success' => 'Transaktion erfolgreich erstellt',
        'create_failed' => 'Eine Transaktion konnte nicht erstellt werden',
        'update_success' => 'Transaktion erfolgreich aktualisiert',
        'update_failed' => 'Eine Transaktion konnte nicht aktualisiert werden',
        'delete_success' => 'Transaktion erfolgreich gelöscht',
        'delete_failed' => 'Eine Transaktion konnte nicht gelöscht werden',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Konten erfolgreich abgerufen',
        'get_failed' => 'Konten konnten nicht abgerufen werden',
        'not_found' => 'Konto konnte nicht gefunden werden',
        'create_success' => 'Konto erfolgreich erstellt',
        'create_error' => 'Konto konnte nicht erstellt werden',
        'update_success' => 'Konto erfolgreich aktualisiert',
        'update_error' => 'Konto konnte nicht aktualisiert werden',
        'delete_success' => 'Konto erfolgreich gelöscht',
        'delete_error' => 'Konto konnte nicht gelöscht werden',
        'get_success' => 'Konto erfolgreich abgerufen',
        'get_error' => 'Konto konnte nicht abgerufen werden',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Rechnung erfolgreich abgerufen',
        'get_error' => 'Rechnung konnte nicht abgerufen werden',
        'create_success' => 'Rechnung erfolgreich erstellt',
        'create_error' => 'Rechnung konnte nicht erstellt werden',
        'update_success' => 'Rechnung erfolgreich aktualisiert',
        'update_error' => 'Rechnung konnte nicht aktualisiert werden',
        'delete_success' => 'Rechnung erfolgreich gelöscht',
        'delete_error' => 'Rechnung konnte nicht erfolgreich gelöscht werden',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumente erfolgreich abgerufen',
        'get_error' => 'Dokumente konnten nicht abgerufen werden',
        'not_found' => 'Dokument konnte nicht gefunden werden',
        'create_failed' => 'Dokument konnte nicht erstellt werden',
        'create_success' => 'Dokument wurde erfolgreich erstellt',
        'update_success' => 'Dokument wurde erfolgreich aktualisiert',
        'update_error' => 'Dokument konnte nicht aktualisiert werden',
        'delete_failed' => 'Dokument konnte nicht erfolgreich gelöscht werden',
        'delete_success' => 'Dokument erfolgreich gelöscht',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Datei erfolgreich abgerufen',
        'get_error' => 'Datei konnte nicht abgerufen werden',
        'not_found' => 'Datei konnte nicht gefunden werden',
        'create_failed' => 'Datei konnte nicht erstellt werden',
        'create_success' => 'Datei wurde erfolgreich erstellt',
        'update_success' => 'Datei wurde erfolgreich aktualisiert',
        'update_failed' => 'Datei konnte nicht aktualisiert werden',
        'delete_failed' => 'Datei konnte nicht erfolgreich gelöscht werden',
        'delete_success' => 'Datei erfolgreich gelöscht',
        'get_success_folder' => 'Ordner erfolgreich abgerufen',
        'get_error_folder' => 'Ordner konnten nicht abgerufen werden',
        'not_found_folder' => 'Ordner konnte nicht gefunden werden',
        'create_failed_folder' => 'Ordner konnte nicht erstellt werden',
        'create_success_folder' => 'Ordner wurde erfolgreich erstellt',
        'update_success_folder' => 'Ordner wurde erfolgreich aktualisiert',
        'update_failed_folder' => 'Ordner konnte nicht aktualisiert werden',
        'delete_failed_folder' => 'Ordner konnte nicht erfolgreich gelöscht werden',
        'delete_success_folder' => 'Ordner erfolgreich gelöscht',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Angebote erfolgreich abgerufen',
        'get_failed' => 'Angebote konnten nicht abgerufen werden',
        'not_found' => 'Angebot konnte nicht gefunden werden',
        'create_failed' => 'Angebot konnte nicht erstellt werden',
        'create_success' => 'Angebot wurde erfolgreich erstellt',
        'convert_success' => 'Angebot wurde erfolgreich in Rechnung konvertiert',
        'update_success' => 'Angebot wurde erfolgreich aktualisiert',
        'delete_success' => 'Angebot wurde erfolgreich gelöscht',
        'delete_failed' => 'Angebot konnte nicht gelöscht werden',
        'update_failed' => 'Angebot konnte nicht aktualisiert werden',
        'share_success' => 'Zitat wurde erfolgreich geteilt',
        'share_failed' => 'Zitat konnte nicht geteilt werden',
        'accept_reject_success' => 'Angebot wurde erfolgreich abgelehnt',
        'send_success' => 'Angebot wurde erfolgreich gesendet',
        'send_failed' => 'Angebot konnte nicht gesendet werden',
        'pdf_failed' => 'PDF generieren fehlgeschlagen',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Rechnungen erfolgreich abgerufen',
        'get_failed' => 'Rechnungen konnten nicht abgerufen werden',
        'not_found' => 'Rechnung konnte nicht gefunden werden',
        'create_failed' => 'Rechnung konnte nicht erstellt werden',
        'create_success' => 'Rechnung wurde erfolgreich erstellt',
        'delete_success' => 'Rechnung wurde erfolgreich gelöscht',
        'update_success' => 'Rechnung wurde erfolgreich aktualisiert',
        'share_success' => 'Rechnung wurde erfolgreich geteilt',
        'share_failed' => 'Zitat konnte nicht geteilt werden',
        'send_success' => 'Rechnung wurde erfolgreich gesendet',
        'pdf_failed' => 'PDF generieren fehlgeschlagen',
        'send_failed' => 'Rechnung konnte nicht gesendet werden',
        'update_failed' => 'Rechnung konnte nicht aktualisiert werden',
        'delete_failed' => 'Rechnung konnte nicht gelöscht werden',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Streifen ist nicht verfügbar',
        'already_paid' => 'Rechnung wurde bereits bezahlt',
        'invalid_key' => 'Ungültiger API-Schlüssel',
        'not_found' => 'Zahlung konnte nicht gefunden werden',
        'success' => 'Zahlung war erfolgreich',
        'failed' => 'Zahlung fehlgeschlagen',
        'paypal_not_available' => 'Paypal nicht verfügbar',
        'invoice' => 'Rechnung',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Benutzer konnte nicht gefunden werden',
        'update_success' => 'Benutzer wurde erfolgreich aktualisiert',
        'password_updated' => 'Passwort wurde erfolgreich aktualisiert',
        'password_not_match' => 'Passwort stimmt nicht überein',
        'password_empty' => 'Passwortfeld ist leer',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Land ist erforderlich',
        'not_enabled' => 'Offenes Banking ist nicht aktiviert',
        'not_found' => 'Offenes Banking nicht gefunden',
        'id_required' => 'ID ist erforderlich',
        'not_provided_infos' => 'Keine Informationen angegeben',
        'requisition_success' => 'Anforderung erfolgreich',
        'requisition_failed' => 'Requisition fehlgeschlagen',
        'session_id_required' => 'Session-ID ist erforderlich',
        'account_id_required' => 'Konto-ID ist erforderlich',
    ],

    'calendar' => [
        'get_success' => 'Ereignis erfolgreich abgerufen',
        'get_error' => 'Ereignis konnte nicht abgerufen werden',
        'not_found' => 'Event konnte nicht gefunden werden',
        'create_failed' => 'Ereignis konnte nicht erstellt werden',
        'create_success' => 'Event wurde erfolgreich erstellt',
        'update_success' => 'Event wurde erfolgreich aktualisiert',
        'update_failed' => 'Ereignis konnte nicht aktualisiert werden',
        'delete_failed' => 'Ereignis konnte nicht erfolgreich gelöscht werden',
        'delete_success' => 'Ereignis erfolgreich gelöscht',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Rechnung',
    ],

    'dashboard' => [
        'income' => 'Einkommen',
        'expense' => 'Kosten',
    ],

    'months' => [
        'january' => 'Januar',
        'february' => 'Februar',
        'march' => 'Marsch',
        'april' => 'Ascherz',
        'may' => 'Maj',
        'june' => 'Juni',
        'july' => 'Juli',
        'august' => 'Luciano',
        'september' => 'September',
        'october' => 'Oktober',
        'november' => 'November',
        'december' => 'Dezember',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rolle konnte nicht gefunden werden',
            'create_failed' => 'Rolle konnte nicht erstellt werden',
            'create_success' => 'Rolle wurde erfolgreich erstellt',
            'update_success' => 'Rolle wurde erfolgreich aktualisiert',
            'delete_success' => 'Rolle wurde erfolgreich gelöscht',
            'delete_failed' => 'Rolle konnte nicht gelöscht werden',
            'super_admin_cannot_be_created' => 'Super Admin-Rolle kann nicht erstellt werden',
            'super_admin_cannot_be_updated' => 'Super Admin-Rolle kann nicht aktualisiert werden',
            'super_admin_cannot_be_deleted' => 'Super-Admin-Rolle kann nicht gelöscht werden',
        ],
        'company_logo' => [
            'upload_success' => 'Firmenlogo wurde erfolgreich hochgeladen',
            'upload_failed' => 'Firmenlogo konnte nicht hochgeladen werden',
            'remove_success' => 'Firmenlogo wurde erfolgreich entfernt',
            'remove_failed' => 'Firmenlogo konnte nicht entfernt werden',
        ],
        'settings' => [
            'update_success' => 'Einstellungen wurden erfolgreich aktualisiert',
            'update_failed' => 'Einstellungen konnten nicht aktualisiert werden',
        ],
        'currency' => [
            'not_found' => 'Währung konnte nicht gefunden werden',
            'create_failed' => 'Währung konnte nicht erstellt werden',
            'create_success' => 'Währung wurde erfolgreich erstellt',
            'update_success' => 'Währung wurde erfolgreich aktualisiert',
            'delete_success' => 'Währung wurde erfolgreich gelöscht',
            'delete_failed' => 'Währung konnte nicht gelöscht werden',
            'rates_updated' => 'Preise wurden erfolgreich aktualisiert',
        ],
        'taxes' => [
            'not_found' => 'Steuer konnte nicht gefunden werden',
            'create_failed' => 'Steuer konnte nicht erstellt werden',
            'create_success' => 'Steuer wurde erfolgreich erstellt',
            'update_success' => 'Steuer wurde erfolgreich aktualisiert',
            'delete_success' => 'Steuer wurde erfolgreich gelöscht',
            'delete_failed' => 'Steuer konnte nicht gelöscht werden',
        ],

        'user' => [
            'not_found' => 'Benutzer konnte nicht gefunden werden',
            'create_failed' => 'Benutzer konnte nicht erstellt werden',
            'create_success' => 'Benutzer wurde erfolgreich erstellt',
            'update_success' => 'Benutzer wurde erfolgreich aktualisiert',
            'update_failed' => 'Benutzer konnte nicht aktualisiert werden',
            'delete_success' => 'Benutzer wurde erfolgreich gelöscht',
            'delete_failed' => 'Benutzer konnte nicht gelöscht werden',
            'password_reset_success' => 'Passwort wurde erfolgreich zurückgesetzt',
            'password_reset_failed' => 'Passwort konnte nicht zurückgesetzt werden',
            'delete_failed_self_account' => 'Sie können Ihr eigenes Konto nicht löschen',
        ],
    ],
];
