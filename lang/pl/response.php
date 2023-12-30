<?php

return [
    'success' => 'Success',
    'failed' => 'Failed',
    'not_found' => 'Not found',
    'create_success' => 'Created successfully',
    'create_failed' => 'Could not be created',
    'update_success' => 'Updated successfully',
    'update_failed' => 'Could not be updated',
    'delete_success' => 'Deleted successfully',
    'delete_failed' => 'Could not be deleted',
    'get_success' => 'Retrieved successfully',
    'get_failed' => 'Could not be retrieved',
    'upload_success' => 'Uploaded successfully',
    'upload_failed' => 'Could not be uploaded',
    'remove_success' => 'Removed successfully',
    'remove_failed' => 'Could not be removed',
    'send_success' => 'Sent successfully',
    'send_failed' => 'Could not be sent',
    'share_success' => 'Shared successfully',
    'share_failed' => 'Could not be shared',
    'accept_reject_success' => 'Accepted/rejected successfully',
    'convert_success' => 'Converted successfully',
    // Auth responses
    'login' => [
        'success' => 'Zalogowano pomyślnie',
        'failed' => 'Logowanie nie powiodło się',
    ],
    'logout' => [
        'success' => 'Wylogowałeś się',
        'failed' => 'Wylogowanie nie powiodło się',
    ],
    'auth' => [
        'failed' => 'Uwierzytelnianie nie powiodło się',
    ],
    'reset' => [
        'success' => 'Hasło zostało zresetowane',
        'failed' => 'Resetowanie hasła nie powiodło się',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Nie znaleziono produktu',
        'get_success' => 'Produkty pobrane pomyślnie',
        'get_failed' => 'Nie można pobrać produktów',
        'create_success' => 'Produkt utworzony pomyślnie',
        'create_failed' => 'Nie można utworzyć produktu',
        'update_success' => 'Produkt został pomyślnie zaktualizowany',
        'update_failed' => 'Nie można zaktualizować produktu',
        'delete_success' => 'Produkt usunięty pomyślnie',
        'delete_failed' => 'Produkt nie może zostać usunięty',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Nie znaleziono partnera',
        'get_success' => 'Partnerzy pobrani pomyślnie',
        'get_failed' => 'Partnerzy nie mogli zostać pobrani',
        'create_success' => 'Partner utworzony pomyślnie',
        'create_failed' => 'Partner nie mógł zostać utworzony',
        'update_success' => 'Partner został pomyślnie zaktualizowany',
        'update_failed' => 'Partner nie mógł zostać zaktualizowany',
        'delete_success' => 'Partner usunięty pomyślnie',
        'delete_failed' => 'Partner nie mógł zostać usunięty',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transakcja nie znaleziona',
        'get_success' => 'Transakcje pobrane pomyślnie',
        'get_failed' => 'Transakcje nie mogły zostać pobrane',
        'create_success' => 'Transakcja utworzona pomyślnie',
        'create_failed' => 'Nie można utworzyć transakcji',
        'update_success' => 'Transakcja zaktualizowana pomyślnie',
        'update_failed' => 'Nie można zaktualizować transakcji',
        'delete_success' => 'Transakcja usunięta pomyślnie',
        'delete_failed' => 'Nie można usunąć transakcji',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Konta pobrane pomyślnie',
        'get_failed' => 'Nie można pobrać kont',
        'not_found' => 'Konto nie zostało znalezione',
        'create_success' => 'Konto utworzone pomyślnie',
        'create_error' => 'Konto nie może zostać utworzone',
        'update_success' => 'Konto zostało pomyślnie zaktualizowane',
        'update_error' => 'Konto nie może zostać zaktualizowane',
        'delete_success' => 'Konto zostało usunięte',
        'delete_error' => 'Konto nie może zostać usunięte',
        'get_success' => 'Konto pobrane pomyślnie',
        'get_error' => 'Konto nie może zostać pobrane',
        'delete_default_account' => 'Domyślne konto nie może zostać usunięte',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Płatność pobrana pomyślnie',
        'get_error' => 'Nie można pobrać rachunku',
        'create_success' => 'Płatność została utworzona pomyślnie',
        'create_error' => 'Nie można utworzyć rachunku',
        'update_success' => 'Rachunek został zaktualizowany',
        'update_error' => 'Nie można zaktualizować rachunku',
        'delete_success' => 'Pomyślnie usunięto rachunek',
        'delete_error' => 'Rachunek nie mógł zostać usunięty pomyślnie',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Dokumenty pobrane pomyślnie',
        'get_error' => 'Nie można pobrać dokumentów',
        'not_found' => 'Dokument nie został znaleziony',
        'create_failed' => 'Nie można utworzyć dokumentu',
        'create_success' => 'Dokument został utworzony pomyślnie',
        'update_success' => 'Dokument został pomyślnie zaktualizowany',
        'update_error' => 'Dokument nie może zostać zaktualizowany',
        'delete_failed' => 'Dokument nie mógł zostać usunięty pomyślnie',
        'delete_success' => 'Dokument usunięty pomyślnie',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'Nie znaleziono pracownika',
        'get_success' => 'Pracownicy pobrani pomyślnie',
        'get_failed' => 'Pracownicy nie mogli zostać pobrani',
        'create_success' => 'Pracownik utworzony pomyślnie',
        'create_failed' => 'Nie można utworzyć pracownika',
        'update_success' => 'Pracownik został pomyślnie zaktualizowany',
        'update_failed' => 'Nie można zaktualizować pracownika',
        'delete_success' => 'Pracownik usunięty pomyślnie',
        'delete_failed' => 'Pracownik nie mógł zostać usunięty',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Plik pobrany pomyślnie',
        'get_error' => 'Nie można pobrać pliku',
        'not_found' => 'Nie można odnaleźć pliku',
        'create_failed' => 'Nie można utworzyć pliku',
        'create_success' => 'Plik został utworzony pomyślnie',
        'update_success' => 'Plik został pomyślnie zaktualizowany',
        'update_failed' => 'Nie można zaktualizować pliku',
        'delete_failed' => 'Nie można usunąć pliku',
        'delete_success' => 'Plik usunięty pomyślnie',
        'get_success_folder' => 'Folder pobrany pomyślnie',
        'get_error_folder' => 'Nie można pobrać folderów',
        'not_found_folder' => 'Folder nie został znaleziony',
        'create_failed_folder' => 'Nie można utworzyć folderu',
        'create_success_folder' => 'Folder został utworzony pomyślnie',
        'update_success_folder' => 'Folder został pomyślnie zaktualizowany',
        'update_failed_folder' => 'Nie można zaktualizować folderu',
        'delete_failed_folder' => 'Folder nie mógł zostać usunięty pomyślnie',
        'delete_success_folder' => 'Folder usunięty pomyślnie',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Oferty pobrane pomyślnie',
        'get_failed' => 'Nie można pobrać ofert',
        'not_found' => 'Nie można znaleźć oferty',
        'create_failed' => 'Nie można utworzyć oferty',
        'create_success' => 'Oferta została utworzona pomyślnie',
        'convert_success' => 'Oferta została przekonwertowana na fakturę',
        'update_success' => 'Oferta została pomyślnie zaktualizowana',
        'delete_success' => 'Oferta została usunięta',
        'delete_failed' => 'Nie można usunąć oferty',
        'update_failed' => 'Nie można zaktualizować oferty',
        'share_success' => 'Oferta została udostępniona pomyślnie',
        'share_failed' => 'Oferta nie może być udostępniona',
        'accept_reject_success' => 'Oferta została odrzucona pomyślnie',
        'send_success' => 'Oferta została wysłana pomyślnie',
        'send_failed' => 'Oferta nie mogła zostać wysłana',
        'pdf_failed' => 'Generowanie PDF nie powiodło się',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Faktury pobrane pomyślnie',
        'get_failed' => 'Faktury nie mogły zostać pobrane',
        'not_found' => 'Faktura nie została znaleziona',
        'create_failed' => 'Faktura nie może zostać utworzona',
        'create_success' => 'Faktura została utworzona pomyślnie',
        'delete_success' => 'Faktura została usunięta',
        'update_success' => 'Faktura została zaktualizowana pomyślnie',
        'share_success' => 'Faktura została udostępniona pomyślnie',
        'share_failed' => 'Oferta nie może być udostępniona',
        'send_success' => 'Faktura została wysłana pomyślnie',
        'pdf_failed' => 'Generowanie PDF nie powiodło się',
        'send_failed' => 'Faktura nie może zostać wysłana',
        'update_failed' => 'Faktura nie może zostać zaktualizowana',
        'delete_failed' => 'Faktura nie może zostać usunięta',
        'transaction_success' => 'Transakcja została dodana pomyślnie',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Pasek nie jest dostępny',
        'already_paid' => 'Faktura została już zapłacona',
        'invalid_key' => 'Nieprawidłowy klucz API',
        'not_found' => 'Płatność nie została znaleziona',
        'success' => 'Płatność zakończona powodzeniem',
        'failed' => 'Płatność nie powiodła się',
        'paypal_not_available' => 'PayPal niedostępny',
        'invoice' => 'Faktura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Nie można odnaleźć użytkownika',
        'update_success' => 'Użytkownik został pomyślnie zaktualizowany',
        'password_updated' => 'Hasło zostało pomyślnie zaktualizowane',
        'password_not_match' => 'Hasło nie pasuje',
        'password_empty' => 'Pole hasła jest puste',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Kraj jest wymagany',
        'not_enabled' => 'Otwarta bankowość nie jest włączona',
        'not_found' => 'Nie znaleziono otwartej bankowości',
        'id_required' => 'ID jest wymagane',
        'not_provided_infos' => 'Nie podano informacji',
        'requisition_success' => 'Zapotrzebowanie udane',
        'requisition_failed' => 'Zapotrzebowanie nie powiodło się',
        'session_id_required' => 'Identyfikator sesji jest wymagany',
        'account_id_required' => 'Identyfikator konta jest wymagany',
    ],

    'calendar' => [
        'get_success' => 'Wydarzenie pobrane pomyślnie',
        'get_error' => 'Nie można pobrać zdarzenia',
        'not_found' => 'Zdarzenie nie zostało znalezione',
        'create_failed' => 'Nie można utworzyć zdarzenia',
        'create_success' => 'Wydarzenie zostało utworzone pomyślnie',
        'update_success' => 'Wydarzenie zostało pomyślnie zaktualizowane',
        'update_failed' => 'Nie można zaktualizować wydarzenia',
        'delete_failed' => 'Wydarzenie nie mogło zostać usunięte pomyślnie',
        'delete_success' => 'Wydarzenie usunięte pomyślnie',
    ],
    'department' => [
        'get_success' => 'Departament pobrany pomyślnie',
        'get_error' => 'Nie można pobrać wydziału',
        'not_found' => 'Nie znaleziono departamentu',
        'create_failed' => 'Nie można utworzyć departamentu',
        'create_success' => 'Departament został utworzony pomyślnie',
        'update_success' => 'Departament został pomyślnie zaktualizowany',
        'update_failed' => 'Nie można zaktualizować departamentu',
        'delete_failed' => 'Departament nie mógł zostać usunięty pomyślnie',
        'delete_success' => 'Departament usunięty pomyślnie',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Faktura',
    ],

    'dashboard' => [
        'income' => 'Dochód',
        'expense' => 'Wydatki',
    ],

    'months' => [
        'january' => 'Styczeń',
        'february' => 'Luty',
        'march' => 'Marzec',
        'april' => 'Kwiecień',
        'may' => 'Maj',
        'june' => 'Czerwiec',
        'july' => 'Lipiec',
        'august' => 'Sierpień',
        'september' => 'Wrzesień',
        'october' => 'Październik',
        'november' => 'Listopad',
        'december' => 'Grudzień',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Nie można odnaleźć roli',
            'create_failed' => 'Nie można utworzyć roli',
            'create_success' => 'Rola została utworzona pomyślnie',
            'update_success' => 'Rola została zaktualizowana pomyślnie',
            'delete_success' => 'Rola została usunięta pomyślnie',
            'delete_failed' => 'Rola nie może zostać usunięta',
            'super_admin_cannot_be_created' => 'Nie można utworzyć roli Super Administratora',
            'super_admin_cannot_be_updated' => 'Rola Super Administratora nie może być zaktualizowana',
            'super_admin_cannot_be_deleted' => 'Nie można usunąć roli Super Administratora',
        ],
        'company_logo' => [
            'upload_success' => 'Logo firmy zostało pomyślnie przesłane',
            'upload_failed' => 'Logo firmy nie może być przesłane',
            'remove_success' => 'Logo firmy zostało usunięte',
            'remove_failed' => 'Logo firmy nie może zostać usunięte',
        ],
        'settings' => [
            'update_success' => 'Ustawienia zostały pomyślnie zaktualizowane',
            'update_failed' => 'Nie można zaktualizować ustawień',
        ],
        'currency' => [
            'not_found' => 'Nie można odnaleźć waluty',
            'create_failed' => 'Nie można utworzyć waluty',
            'create_success' => 'Waluta została utworzona pomyślnie',
            'update_success' => 'Waluta została pomyślnie zaktualizowana',
            'delete_success' => 'Waluta została usunięta',
            'delete_failed' => 'Waluta nie może zostać usunięta',
            'rates_updated' => 'Stawki zostały pomyślnie zaktualizowane',
        ],
        'taxes' => [
            'not_found' => 'Podatek nie został znaleziony',
            'create_failed' => 'Nie można utworzyć podatku',
            'create_success' => 'Podatek został utworzony pomyślnie',
            'update_success' => 'Podatek został pomyślnie zaktualizowany',
            'delete_success' => 'Podatek został usunięty pomyślnie',
            'delete_failed' => 'Podatek nie może zostać usunięty',
        ],

        'user' => [
            'not_found' => 'Nie można odnaleźć użytkownika',
            'create_failed' => 'Nie można utworzyć użytkownika',
            'create_success' => 'Użytkownik został utworzony pomyślnie',
            'update_success' => 'Użytkownik został pomyślnie zaktualizowany',
            'update_failed' => 'Użytkownik nie może zostać zaktualizowany',
            'delete_success' => 'Użytkownik został usunięty pomyślnie',
            'delete_failed' => 'Użytkownik nie może zostać usunięty',
            'password_reset_success' => 'Hasło zostało zresetowane pomyślnie',
            'password_reset_failed' => 'Nie można zresetować hasła',
            'delete_failed_self_account' => 'Nie możesz usunąć własnego konta',
        ],
    ],
    'memory_used' => 'Użyta pamięć',
    'memory_available' => 'Pamięć dostępna',
    'disk_used' => 'Użyty dysk',
    'disk_available' => 'Dysk dostępny',
];
