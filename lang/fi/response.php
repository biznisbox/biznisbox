<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Olet onnistuneesti kirjautunut sisään',
        'failed' => 'Kirjautuminen epäonnistui',
    ],
    'logout' => [
        'success' => 'Olet onnistuneesti kirjautunut ulos',
        'failed' => 'Uloskirjautuminen epäonnistui',
    ],
    'auth' => [
        'failed' => 'Todennus epäonnistui',
    ],
    'reset' => [
        'success' => 'Salasanan vaihtaminen onnistui',
        'failed' => 'Salasanan vaihtaminen epäonnistui',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Tuotetta ei löydy',
        'get_success' => 'Tuotteita haettu onnistuneesti',
        'get_failed' => 'Tuotteita ei voitu noutaa',
        'create_success' => 'Tuote luotiin onnistuneesti',
        'create_failed' => 'Tuotetta ei voitu luoda',
        'update_success' => 'Tuote päivitetty onnistuneesti',
        'update_failed' => 'Tuotetta ei voitu päivittää',
        'delete_success' => 'Tuote poistettu onnistuneesti',
        'delete_failed' => 'Tuotetta ei voitu poistaa',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Kumppania ei löytynyt',
        'get_success' => 'Kumppanit haettu onnistuneesti',
        'get_failed' => 'Kumppaneita ei voitu hakea',
        'create_success' => 'Kumppani luotu onnistuneesti',
        'create_failed' => 'Kumppania ei voitu luoda',
        'update_success' => 'Kumppani päivitetty onnistuneesti',
        'update_failed' => 'Kumppania ei voitu päivittää',
        'delete_success' => 'Kumppanin poisto onnistui',
        'delete_failed' => 'Kumppania ei voitu poistaa',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Tapahtumaa ei löytynyt',
        'get_success' => 'Maksutapahtumat noudettu onnistuneesti',
        'get_failed' => 'Tapahtumia ei voitu noutaa',
        'create_success' => 'Tapahtuma luotu onnistuneesti',
        'create_failed' => 'Tapahtumaa ei voitu luoda',
        'update_success' => 'Tapahtuma päivitetty onnistuneesti',
        'update_failed' => 'Tapahtumaa ei voitu päivittää',
        'delete_success' => 'Tapahtuma poistettu onnistuneesti',
        'delete_failed' => 'Tapahtumaa ei voitu poistaa',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Tilit noudettu onnistuneesti',
        'get_failed' => 'Tilejä ei voitu noutaa',
        'not_found' => 'Tiliä ei löytynyt',
        'create_success' => 'Tilin luominen onnistui',
        'create_error' => 'Tiliä ei voitu luoda',
        'update_success' => 'Tili päivitetty onnistuneesti',
        'update_error' => 'Tiliä ei voitu päivittää',
        'delete_success' => 'Tilin poisto onnistui',
        'delete_error' => 'Tiliä ei voitu poistaa',
        'get_success' => 'Tili haettu onnistuneesti',
        'get_error' => 'Tiliä ei voitu hakea',
        'delete_default_account' => 'Oletustiliä ei voi poistaa',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Laskua haettu onnistuneesti',
        'get_error' => 'Laskua ei voitu hakea',
        'create_success' => 'Lasku luotu onnistuneesti',
        'create_error' => 'Laskua ei voitu luoda',
        'update_success' => 'Lasku päivitetty onnistuneesti',
        'update_error' => 'Laskua ei voitu päivittää',
        'delete_success' => 'Lasku poistettu onnistuneesti',
        'delete_error' => 'Laskua ei voitu poistaa onnistuneesti',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Asiakirjat noudettu onnistuneesti',
        'get_error' => 'Asiakirjoja ei voitu hakea',
        'not_found' => 'Asiakirjaa ei löytynyt',
        'create_failed' => 'Asiakirjaa ei voitu luoda',
        'create_success' => 'Asiakirja luotiin onnistuneesti',
        'update_success' => 'Asiakirja päivitettiin onnistuneesti',
        'update_error' => 'Asiakirjaa ei voitu päivittää',
        'delete_failed' => 'Asiakirjaa ei voitu poistaa onnistuneesti',
        'delete_success' => 'Asiakirjan poisto onnistui',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'Työntekijää ei löytynyt',
        'get_success' => 'Työntekijät nousivat onnistuneesti',
        'get_failed' => 'Työntekijöitä ei voitu noutaa',
        'create_success' => 'Työntekijä luotu onnistuneesti',
        'create_failed' => 'Työntekijää ei voitu luoda',
        'update_success' => 'Työntekijä päivitetty onnistuneesti',
        'update_failed' => 'Työntekijää ei voitu päivittää',
        'delete_success' => 'Työntekijän poisto onnistui',
        'delete_failed' => 'Työntekijää ei voitu poistaa',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Tiedosto noudettu onnistuneesti',
        'get_error' => 'Tiedostoa ei voitu hakea',
        'not_found' => 'Tiedostoa ei löytynyt',
        'create_failed' => 'Tiedostoa ei voitu luoda',
        'create_success' => 'Tiedosto luotiin onnistuneesti',
        'update_success' => 'Tiedosto päivitettiin onnistuneesti',
        'update_failed' => 'Tiedostoa ei voitu päivittää',
        'delete_failed' => 'Tiedostoa ei voitu poistaa onnistuneesti',
        'delete_success' => 'Tiedosto poistettu onnistuneesti',
        'get_success_folder' => 'Kansion nouto onnistui',
        'get_error_folder' => 'Kansioita ei voitu noutaa',
        'not_found_folder' => 'Kansiota ei löytynyt',
        'create_failed_folder' => 'Kansiota ei voitu luoda',
        'create_success_folder' => 'Kansio luotiin onnistuneesti',
        'update_success_folder' => 'Kansio päivitettiin onnistuneesti',
        'update_failed_folder' => 'Kansiota ei voitu päivittää',
        'delete_failed_folder' => 'Kansiota ei voitu poistaa onnistuneesti',
        'delete_success_folder' => 'Kansio poistettu onnistuneesti',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Lainaukset haettu onnistuneesti',
        'get_failed' => 'Tarjouksia ei voitu noutaa',
        'not_found' => 'Tarjousta ei löytynyt',
        'create_failed' => 'Tarjousta ei voitu luoda',
        'create_success' => 'Tarjous luotiin onnistuneesti',
        'convert_success' => 'Tarjous muunnettiin laskuksi onnistuneesti',
        'update_success' => 'Tarjous päivitettiin onnistuneesti',
        'delete_success' => 'Tarjous poistettiin onnistuneesti',
        'delete_failed' => 'Tarjousta ei voitu poistaa',
        'update_failed' => 'Tarjousta ei voitu päivittää',
        'share_success' => 'Tarjous jaettu onnistuneesti',
        'share_failed' => 'Tarjousta ei voitu jakaa',
        'accept_reject_success' => 'Tarjous hylättiin onnistuneesti',
        'send_success' => 'Tarjous lähetetty onnistuneesti',
        'send_failed' => 'Tarjousta ei voitu lähettää',
        'pdf_failed' => 'PDF: n luominen epäonnistui',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Laskut haettu onnistuneesti',
        'get_failed' => 'Laskuja ei voitu noutaa',
        'not_found' => 'Laskua ei löytynyt',
        'create_failed' => 'Laskua ei voitu luoda',
        'create_success' => 'Lasku luotiin onnistuneesti',
        'delete_success' => 'Lasku poistettiin onnistuneesti',
        'update_success' => 'Lasku päivitettiin onnistuneesti',
        'share_success' => 'Lasku jaettiin onnistuneesti',
        'share_failed' => 'Tarjousta ei voitu jakaa',
        'send_success' => 'Lasku lähetettiin onnistuneesti',
        'pdf_failed' => 'PDF: n luominen epäonnistui',
        'send_failed' => 'Laskua ei voitu lähettää',
        'update_failed' => 'Laskua ei voitu päivittää',
        'delete_failed' => 'Laskua ei voitu poistaa',
        'transaction_success' => 'Tapahtuma lisättiin onnistuneesti',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Raita ei ole saatavilla',
        'already_paid' => 'Lasku on jo maksettu',
        'invalid_key' => 'Virheellinen API-avain',
        'not_found' => 'Maksua ei löytynyt',
        'success' => 'Maksu onnistui',
        'failed' => 'Maksu epäonnistui',
        'paypal_not_available' => 'PayPal ei saatavilla',
        'invoice' => 'Lasku',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Käyttäjää ei löytynyt',
        'update_success' => 'Käyttäjä päivitettiin onnistuneesti',
        'password_updated' => 'Salasana päivitettiin onnistuneesti',
        'password_not_match' => 'Salasana ei täsmää',
        'password_empty' => 'Salasanakenttä on tyhjä',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Maa vaaditaan',
        'not_enabled' => 'Avoin pankkitoiminta ei ole käytössä',
        'not_found' => 'Avoin pankkitoiminta ei löytynyt',
        'id_required' => 'Tunnus vaaditaan',
        'not_provided_infos' => 'Ei toimitettuja tietoja',
        'requisition_success' => 'Hankinnan onnistuminen',
        'requisition_failed' => 'Vaatimus epäonnistui',
        'session_id_required' => 'Istunnon tunnus vaaditaan',
        'account_id_required' => 'Tilin tunnus vaaditaan',
    ],

    'calendar' => [
        'get_success' => 'Tapahtuma noudettu onnistuneesti',
        'get_error' => 'Tapahtumaa ei voitu noutaa',
        'not_found' => 'Tapahtumaa ei löytynyt',
        'create_failed' => 'Tapahtumaa ei voitu luoda',
        'create_success' => 'Tapahtuma luotiin onnistuneesti',
        'update_success' => 'Tapahtuma päivitettiin onnistuneesti',
        'update_failed' => 'Tapahtumaa ei voitu päivittää',
        'delete_failed' => 'Tapahtumaa ei voitu poistaa onnistuneesti',
        'delete_success' => 'Tapahtuman poisto onnistui',
    ],
    'department' => [
        'get_success' => 'Osasto noudettu onnistuneesti',
        'get_error' => 'Osastoa ei voitu hakea',
        'not_found' => 'Osastoa ei löytynyt',
        'create_failed' => 'Osastoa ei voitu luoda',
        'create_success' => 'Osasto luotiin onnistuneesti',
        'update_success' => 'Osasto päivitettiin onnistuneesti',
        'update_failed' => 'Osastoa ei voitu päivittää',
        'delete_failed' => 'Osastoa ei voitu poistaa onnistuneesti',
        'delete_success' => 'Osasto poistettu onnistuneesti',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Lasku',
    ],

    'dashboard' => [
        'income' => 'Tulot',
        'expense' => 'Menot',
    ],

    'months' => [
        'january' => 'Tammikuu',
        'february' => 'Helmikuu',
        'march' => 'Maaliskuu',
        'april' => 'Huhtikuu',
        'may' => 'Maj',
        'june' => 'Kesäkuu',
        'july' => 'Heinäkuu',
        'august' => 'Elokuu',
        'september' => 'Syyskuu',
        'october' => 'Lokakuu',
        'november' => 'Marraskuu',
        'december' => 'Joulukuu',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Roolia ei löytynyt',
            'create_failed' => 'Roolia ei voitu luoda',
            'create_success' => 'Rooli luotiin onnistuneesti',
            'update_success' => 'Rooli päivitettiin onnistuneesti',
            'delete_success' => 'Rooli poistettu onnistuneesti',
            'delete_failed' => 'Roolia ei voitu poistaa',
            'super_admin_cannot_be_created' => 'Pääkäyttäjän roolia ei voi luoda',
            'super_admin_cannot_be_updated' => 'Super Admin roolia ei voi päivittää',
            'super_admin_cannot_be_deleted' => 'Super Admin roolia ei voi poistaa',
        ],
        'company_logo' => [
            'upload_success' => 'Yrityksen logo ladattu onnistuneesti',
            'upload_failed' => 'Yrityksen logoa ei voitu ladata',
            'remove_success' => 'Yrityksen logo poistettiin onnistuneesti',
            'remove_failed' => 'Yrityksen logoa ei voitu poistaa',
        ],
        'settings' => [
            'update_success' => 'Asetukset päivitettiin onnistuneesti',
            'update_failed' => 'Asetuksia ei voitu päivittää',
        ],
        'currency' => [
            'not_found' => 'Valuutta ei löytynyt',
            'create_failed' => 'Valuutta ei voitu luoda',
            'create_success' => 'Valuutta luotiin onnistuneesti',
            'update_success' => 'Valuutta päivitettiin onnistuneesti',
            'delete_success' => 'Valuutta poistettiin onnistuneesti',
            'delete_failed' => 'Valuutta ei voitu poistaa',
            'rates_updated' => 'Hinnat päivitettiin onnistuneesti',
        ],
        'taxes' => [
            'not_found' => 'Veroa ei löytynyt',
            'create_failed' => 'Veroa ei voitu luoda',
            'create_success' => 'Vero luotiin onnistuneesti',
            'update_success' => 'Vero päivitettiin onnistuneesti',
            'delete_success' => 'Vero poistettu onnistuneesti',
            'delete_failed' => 'Veroa ei voitu poistaa',
        ],

        'user' => [
            'not_found' => 'Käyttäjää ei löytynyt',
            'create_failed' => 'Käyttäjää ei voitu luoda',
            'create_success' => 'Käyttäjä luotiin onnistuneesti',
            'update_success' => 'Käyttäjä päivitettiin onnistuneesti',
            'update_failed' => 'Käyttäjää ei voitu päivittää',
            'delete_success' => 'Käyttäjä poistettiin onnistuneesti',
            'delete_failed' => 'Käyttäjää ei voitu poistaa',
            'password_reset_success' => 'Salasanan vaihtaminen onnistui',
            'password_reset_failed' => 'Salasanaa ei voitu nollata',
            'delete_failed_self_account' => 'Et voi poistaa omaa tiliäsi',
        ],
    ],
    'memory_used' => 'Muistia käytetty',
    'memory_available' => 'Muistia saatavilla',
    'disk_used' => 'Käytetty levy',
    'disk_available' => 'Levy saatavilla',
];