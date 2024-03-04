<?php

return [
    'success' => 'Geslaagd',
    'failed' => 'Mislukt',
    'not_found' => 'Niet gevonden',
    'create_success' => 'Succesvol aangemaakt',
    'create_failed' => 'Kon niet worden aangemaakt',
    'update_success' => 'Succesvol bijgewerkt',
    'update_failed' => 'Kon niet worden bijgewerkt',
    'delete_success' => 'Succesvol verwijderd',
    'delete_failed' => 'Kan niet worden verwijderd',
    'get_success' => 'Met succes opgehaald',
    'get_failed' => 'Kan niet worden opgehaald',
    'upload_success' => 'Succesvol geüpload',
    'upload_failed' => 'Kon niet worden geüpload',
    'remove_success' => 'Succesvol verwijderd',
    'remove_failed' => 'Kan niet worden verwijderd',
    'send_success' => 'Succesvol verzonden',
    'send_failed' => 'Kon niet worden verzonden',
    'share_success' => 'Succesvol gedeeld',
    'share_failed' => 'Kan niet worden gedeeld',
    'accept_reject_success' => 'Aanvaard/Afwijzen geslaagd',
    'convert_success' => 'Succesvol geconverteerd',
    'pdf_failed' => 'Genereren PDF mislukt',
    'notification_success' => 'Notificatie is succesvol verzonden',
    'notification_failed' => 'Kennisgeving kon niet worden verzonden',
    'no_key_provided' => 'Geen sleutel opgegeven',
    'ping' => 'API werkt',
    // Auth responses
    'login' => [
        'success' => 'Je bent succesvol ingelogd',
        'failed' => 'Inloggen mislukt',
    ],
    'logout' => [
        'success' => 'U bent succesvol uitgelogd',
        'failed' => 'Afmelden mislukt',
    ],
    'auth' => [
        'failed' => 'Authenticatie mislukt',
    ],
    'reset' => [
        'success' => 'Wachtwoord succesvol opnieuw instellen',
        'failed' => 'Wachtwoord opnieuw instellen mislukt',
    ],
    // Product responses
    'product' => [
        'not_found' => 'Product niet gevonden',
        'get_success' => 'Producten succesvol opgehaald',
        'get_failed' => 'Producten konden niet worden opgehaald',
        'create_success' => 'Product succesvol aangemaakt',
        'create_failed' => 'Een product kon niet aangemaakt worden',
        'update_success' => 'Product succesvol bijgewerkt',
        'update_failed' => 'Een product kon niet worden bijgewerkt',
        'delete_success' => 'Product succesvol verwijderd',
        'delete_failed' => 'Een product kon niet verwijderd worden',
    ],
    // Partner responses
    'partner' => [
        'not_found' => 'Partner niet gevonden',
        'get_success' => 'Partners succesvol opgehaald',
        'get_failed' => 'Partners konden niet worden opgehaald',
        'create_success' => 'Partner succesvol aangemaakt',
        'create_failed' => 'Een partner kon niet aangemaakt worden',
        'update_success' => 'Partner succesvol bijgewerkt',
        'update_failed' => 'Een partner kon niet worden bijgewerkt',
        'delete_success' => 'Partner succesvol verwijderd',
        'delete_failed' => 'Een partner kon niet verwijderd worden',
    ],
    // Transaction responses
    'transaction' => [
        'not_found' => 'Transactie niet gevonden',
        'get_success' => 'Transacties succesvol opgehaald',
        'get_failed' => 'Transacties konden niet worden opgehaald',
        'create_success' => 'Transactie succesvol aangemaakt',
        'create_failed' => 'Er kon geen transactie worden aangemaakt',
        'update_success' => 'Transactie succesvol bijgewerkt',
        'update_failed' => 'Een transactie kon niet worden bijgewerkt',
        'delete_success' => 'Transactie succesvol verwijderd',
        'delete_failed' => 'Een transactie kon niet worden verwijderd',
    ],
    //Account responses
    'accounts' => [
        'get_success' => 'Accounts met succes opgehaald',
        'get_failed' => 'Accounts konden niet worden opgehaald',
        'not_found' => 'Account kon niet worden gevonden',
        'create_success' => 'Account succesvol aangemaakt',
        'create_error' => 'Account kon niet worden aangemaakt',
        'update_success' => 'Account succesvol bijgewerkt',
        'update_error' => 'Account kon niet worden bijgewerkt',
        'delete_success' => 'Account succesvol verwijderd',
        'delete_error' => 'Account kon niet worden verwijderd',
        'get_success' => 'Account met succes opgehaald',
        'get_error' => 'Account kon niet worden opgehaald',
        'delete_default_account' => 'Standaardaccount kan niet worden verwijderd',
    ],
    //Bill responses
    'bill' => [
        'get_success' => 'Factuur succesvol opgehaald',
        'get_error' => 'Rekening kon niet worden opgehaald',
        'create_success' => 'Rekening succesvol aangemaakt',
        'create_error' => 'Factuur kon niet worden aangemaakt',
        'update_success' => 'Factuur succesvol bijgewerkt',
        'update_error' => 'Factuur kon niet worden bijgewerkt',
        'delete_success' => 'Factuur succesvol verwijderd',
        'delete_error' => 'Factuur kon niet met succes worden verwijderd',
    ],
    //Document responses
    'document' => [
        'get_success' => 'Documenten met succes opgehaald',
        'get_error' => 'Documenten konden niet worden opgehaald',
        'not_found' => 'Document kon niet gevonden worden',
        'create_failed' => 'Document kon niet aangemaakt worden',
        'create_success' => 'Document is met succes gemaakt',
        'update_success' => 'Document is met succes bijgewerkt',
        'update_error' => 'Document kon niet worden bijgewerkt',
        'delete_failed' => 'Document kon niet met succes verwijderd worden',
        'delete_success' => 'Document met succes verwijderd',
    ],
    // Employee responses
    'employee' => [
        'not_found' => 'Medewerker niet gevonden',
        'get_success' => 'Werknemers succesvol ontvangen',
        'get_failed' => 'Werknemers konden niet worden opgehaald',
        'create_success' => 'Werknemer succesvol aangemaakt',
        'create_failed' => 'Een werknemer kon niet aangemaakt worden',
        'update_success' => 'Werknemer bijgewerkt',
        'update_failed' => 'Een werknemer kon niet worden bijgewerkt',
        'delete_success' => 'Medewerker succesvol verwijderd',
        'delete_failed' => 'Een werknemer kon niet worden verwijderd',
    ],
    // Archive responses
    'archive' => [
        'get_success' => 'Bestand met succes opgehaald',
        'get_error' => 'Bestand kan niet worden opgehaald',
        'not_found' => 'Bestand kon niet worden gevonden',
        'create_failed' => 'Bestand kon niet worden aangemaakt',
        'create_success' => 'Bestand is met succes aangemaakt',
        'update_success' => 'Bestand is met succes bijgewerkt',
        'update_failed' => 'Bestand kon niet worden bijgewerkt',
        'delete_failed' => 'Bestand kon niet met succes worden verwijderd',
        'delete_success' => 'Bestand succesvol verwijderd',
        'get_success_folder' => 'Map met succes opgehaald',
        'get_error_folder' => 'Mappen konden niet worden opgehaald',
        'not_found_folder' => 'Map kon niet worden gevonden',
        'create_failed_folder' => 'Map kon niet worden aangemaakt',
        'create_success_folder' => 'Map is met succes aangemaakt',
        'update_success_folder' => 'Map is met succes bijgewerkt',
        'update_failed_folder' => 'Map kon niet worden bijgewerkt',
        'delete_failed_folder' => 'Map kon niet met succes worden verwijderd',
        'delete_success_folder' => 'Map succesvol verwijderd',
    ],
    //Quote responses
    'quote' => [
        'get_success' => 'Offertes met succes opgehaald',
        'get_failed' => 'Offertes konden niet worden opgehaald',
        'not_found' => 'Prijsopgave kon niet worden gevonden',
        'create_failed' => 'Prijsopgave kon niet worden aangemaakt',
        'create_success' => 'Prijsopgave is succesvol aangemaakt',
        'convert_success' => 'Prijsopgave is succesvol omgezet naar factuur',
        'update_success' => 'Offerte is succesvol bijgewerkt',
        'delete_success' => 'Prijsopgave is succesvol verwijderd',
        'delete_failed' => 'Prijsopgave kon niet worden verwijderd',
        'update_failed' => 'Prijsopgave kon niet worden bijgewerkt',
        'share_success' => 'Offerte werd met succes gedeeld',
        'share_failed' => 'Prijsopgave kon niet worden gedeeld',
        'accept_reject_success' => 'Prijsopgave is succesvol afgewezen',
        'send_success' => 'Prijsopgave is succesvol verzonden',
        'send_failed' => 'Prijsopgave kon niet worden verzonden',
        'pdf_failed' => 'Genereren PDF mislukt',
    ],
    // Support ticket message responses
    'support_ticket_message' => [
        'get_success' => 'Ondersteuning van ticketberichten die met succes zijn ontvangen',
        'get_failed' => 'Support ticketberichten konden niet worden opgehaald',
        'not_found' => 'Support ticketbericht kon niet worden gevonden',
        'create_failed' => 'Support ticketbericht kon niet worden gemaakt',
        'create_success' => 'Support ticketbericht is succesvol gemaakt',
        'update_success' => 'Support ticketbericht is succesvol bijgewerkt',
        'update_failed' => 'Support ticketbericht kon niet worden bijgewerkt',
        'delete_failed' => 'Support ticketbericht kon niet met succes worden verwijderd',
        'delete_success' => 'Support ticketbericht succesvol verwijderd',
    ],
    //Invoice responses
    'invoice' => [
        'get_success' => 'Facturen met succes opgehaald',
        'get_failed' => 'Facturen konden niet worden opgehaald',
        'not_found' => 'Factuur kon niet worden gevonden',
        'create_failed' => 'Factuur kon niet worden aangemaakt',
        'create_success' => 'Factuur is succesvol aangemaakt',
        'delete_success' => 'Factuur is succesvol verwijderd',
        'update_success' => 'Factuur is succesvol bijgewerkt',
        'share_success' => 'Factuur werd succesvol gedeeld',
        'share_failed' => 'Prijsopgave kon niet worden gedeeld',
        'send_success' => 'Factuur is succesvol verzonden',
        'pdf_failed' => 'Genereren PDF mislukt',
        'send_failed' => 'Factuur kon niet worden verzonden',
        'update_failed' => 'Factuur kon niet worden bijgewerkt',
        'delete_failed' => 'Factuur kon niet worden verwijderd',
        'transaction_success' => 'Transactie is met succes toegevoegd',
        'notification_success' => 'Notificatie is succesvol verzonden',
        'notification_failed' => 'Kennisgeving kon niet worden verzonden',
    ],
    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe is niet beschikbaar',
        'already_paid' => 'Factuur is al betaald',
        'invalid_key' => 'Ongeldige API-sleutel',
        'not_found' => 'Betaling kon niet worden gevonden',
        'success' => 'Betaling is geslaagd',
        'failed' => 'Betaling mislukt',
        'paypal_not_available' => 'Paypal niet beschikbaar',
        'invoice' => 'Factuur',
    ],
    //Support ticket responses
    'support_ticket' => [
        'get_success' => 'Support tickets met succes opgehaald',
        'get_failed' => 'Support tickets konden niet worden opgehaald',
        'not_found' => 'Support ticket kon niet worden gevonden',
        'create_failed' => 'Support ticket kon niet worden aangemaakt',
        'create_success' => 'Support ticket is succesvol gemaakt',
        'update_success' => 'Support ticket is succesvol bijgewerkt',
        'update_failed' => 'Support ticket kon niet worden bijgewerkt',
        'delete_failed' => 'Support ticket kon niet met succes worden verwijderd',
        'delete_success' => 'Support ticket succesvol verwijderd',
        'get_number_success' => 'Support ticket nummer opgehaald met succes',
        'get_number_failed' => 'Support ticketnummer kon niet worden opgehaald',
        'send_success' => 'Support ticketbericht is succesvol verzonden',
        'send_failed' => 'Support ticketbericht kon niet worden verzonden',
        'share_success' => 'Support ticket werd met succes gedeeld',
        'share_failed' => 'Support ticket kon niet worden gedeeld',
    ],
    //Profile responses
    'user' => [
        'not_found' => 'Gebruiker kon niet worden gevonden',
        'update_success' => 'Gebruiker is succesvol bijgewerkt',
        'password_updated' => 'Wachtwoord is met succes bijgewerkt',
        'password_not_match' => 'Wachtwoord komt niet overeen',
        'password_empty' => 'Wachtwoordveld is leeg',
        'avatar_deleted' => 'Avatar is succesvol verwijderd',
        'avatar_not_found' => 'Avatar kon niet worden gevonden',
        'avatar_updated' => 'Avatar is succesvol bijgewerkt',
    ],
    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Land is vereist',
        'not_enabled' => 'Open bankieren is niet ingeschakeld',
        'not_found' => 'Open bankieren niet gevonden',
        'id_required' => 'ID is verplicht',
        'not_provided_infos' => 'Geen informatie verstrekt',
        'requisition_success' => 'Bestelopdracht gelukt',
        'requisition_failed' => 'Bestelopdracht mislukt',
        'session_id_required' => 'Sessie-ID is vereist',
        'account_id_required' => 'Account-ID is vereist',
    ],
    // Calendar responses
    'calendar' => [
        'get_success' => 'Afspraak met succes opgehaald',
        'get_error' => 'Gebeurtenis kon niet worden opgehaald',
        'not_found' => 'Afspraak kon niet worden gevonden',
        'create_failed' => 'Afspraak kon niet aangemaakt worden',
        'create_success' => 'Afspraak is met succes gemaakt',
        'update_success' => 'Afspraak is met succes bijgewerkt',
        'update_failed' => 'Gebeurtenis kon niet worden bijgewerkt',
        'delete_failed' => 'Afspraak kon niet met succes worden verwijderd',
        'delete_success' => 'Afspraak succesvol verwijderd',
    ],
    'department' => [
        'get_success' => 'Afdeling succesvol opgehaald',
        'get_error' => 'Afdeling kon niet worden opgehaald',
        'not_found' => 'Afdeling kon niet worden gevonden',
        'create_failed' => 'Afdeling kon niet aangemaakt worden',
        'create_success' => 'Afdeling is succesvol aangemaakt',
        'update_success' => 'Afdeling met succes bijgewerkt',
        'update_failed' => 'Afdeling kon niet worden bijgewerkt',
        'delete_failed' => 'Afdeling kon niet met succes verwijderd worden',
        'delete_success' => 'Afdeling succesvol verwijderd',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Factuur',
    ],
    'dashboard' => [
        'income' => 'Inkomsten',
        'expense' => 'Kosten',
    ],
    // Months
    'months' => [
        'january' => 'januari',
        'february' => 'februari',
        'march' => 'maart',
        'april' => 'april',
        'may' => 'Maj',
        'june' => 'juni',
        'july' => 'juli',
        'august' => 'augustus',
        'september' => 'september',
        'october' => 'oktober',
        'november' => 'november',
        'december' => 'december',
    ],
    //  Admin responses
    'admin' => [
        'role' => [
            'not_found' => 'Rol kon niet worden gevonden',
            'create_failed' => 'Rol kon niet aangemaakt worden',
            'create_success' => 'Rol is succesvol gemaakt',
            'update_success' => 'Rol is met succes bijgewerkt',
            'delete_success' => 'Rol is succesvol verwijderd',
            'delete_failed' => 'Rol kon niet worden verwijderd',
            'super_admin_cannot_be_created' => 'Super Admin rol kan niet worden gemaakt',
            'super_admin_cannot_be_updated' => 'Super Admin rol kan niet worden bijgewerkt',
            'super_admin_cannot_be_deleted' => 'Super Admin rol kan niet worden verwijderd',
        ],
        'company_logo' => [
            'upload_success' => 'Bedrijfslogo is succesvol geüpload',
            'upload_failed' => 'Bedrijfslogo kon niet worden geüpload',
            'remove_success' => 'Bedrijfslogo is succesvol verwijderd',
            'remove_failed' => 'Bedrijfslogo kon niet worden verwijderd',
        ],
        'settings' => [
            'update_success' => 'Instellingen zijn met succes bijgewerkt',
            'update_failed' => 'Instellingen konden niet worden bijgewerkt',
        ],
        'currency' => [
            'not_found' => 'Valuta kon niet worden gevonden',
            'create_failed' => 'Valuta kon niet worden aangemaakt',
            'create_success' => 'Valuta werd met succes aangemaakt',
            'update_success' => 'Valuta is met succes bijgewerkt',
            'delete_success' => 'Valuta met succes verwijderd',
            'delete_failed' => 'Valuta kon niet worden verwijderd',
            'rates_updated' => 'Tarieven zijn succesvol bijgewerkt',
        ],
        'taxes' => [
            'not_found' => 'Belasting kon niet worden gevonden',
            'create_failed' => 'Belasting kon niet worden aangemaakt',
            'create_success' => 'BTW is succesvol aangemaakt',
            'update_success' => 'BTW is succesvol bijgewerkt',
            'delete_success' => 'BTW is succesvol verwijderd',
            'delete_failed' => 'Belasting kon niet worden verwijderd',
        ],
        'user' => [
            'not_found' => 'Gebruiker kon niet worden gevonden',
            'create_failed' => 'Gebruiker kon niet worden aangemaakt',
            'create_success' => 'Gebruiker is succesvol aangemaakt',
            'update_success' => 'Gebruiker is succesvol bijgewerkt',
            'update_failed' => 'Gebruiker kon niet worden bijgewerkt',
            'delete_success' => 'Gebruiker is succesvol verwijderd',
            'delete_failed' => 'Gebruiker kon niet worden verwijderd',
            'password_reset_success' => 'Wachtwoord is succesvol opnieuw ingesteld',
            'password_reset_failed' => 'Wachtwoord kon niet worden gereset',
            'delete_failed_self_account' => 'U kunt uw eigen account niet verwijderen',
        ],
        'email' => [
            'test_email_sent' => 'Test e-mail is succesvol verzonden',
            'test_email_failed' => 'Test e-mail kon niet worden verzonden',
        ],
    ],
    'memory_used' => 'Geheugen gebruikt',
    'memory_available' => 'Geheugen beschikbaar',
    'disk_used' => 'Schijf gebruikt',
    'disk_available' => 'Schijf beschikbaar',
];
