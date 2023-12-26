<?php

return [
    // Auth responses
    'login' => [
        'success' => 'V-ați conectat cu succes',
        'failed' => 'Autentificare eșuată',
    ],
    'logout' => [
        'success' => 'V-ați deconectat cu succes',
        'failed' => 'Deconectare eșuată',
    ],
    'auth' => [
        'failed' => 'Autentificare eșuată',
    ],
    'reset' => [
        'success' => 'Parola de resetare cu succes',
        'failed' => 'Resetarea parolei a eșuat',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produsul nu a fost găsit',
        'get_success' => 'Produse preluate cu succes',
        'get_failed' => 'Produsele nu au putut fi preluate',
        'create_success' => 'Produs creat cu succes',
        'create_failed' => 'Un produs nu a putut fi creat',
        'update_success' => 'Produs actualizat cu succes',
        'update_failed' => 'Un produs nu a putut fi actualizat',
        'delete_success' => 'Produs șters cu succes',
        'delete_failed' => 'Un produs nu a putut fi șters',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Partenerul nu a fost găsit',
        'get_success' => 'Parteneri recuperați cu succes',
        'get_failed' => 'Partenerii nu au putut fi recuperați',
        'create_success' => 'Partener creat cu succes',
        'create_failed' => 'Un partener nu a putut fi creat',
        'update_success' => 'Partener actualizat cu succes',
        'update_failed' => 'Un partener nu a putut fi actualizat',
        'delete_success' => 'Partener șters cu succes',
        'delete_failed' => 'Un partener nu a putut fi șters',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Tranzacția nu a fost găsită',
        'get_success' => 'Tranzacții recuperate cu succes',
        'get_failed' => 'Tranzacțiile nu au putut fi recuperate',
        'create_success' => 'Tranzacție creată cu succes',
        'create_failed' => 'Tranzacția nu a putut fi creată',
        'update_success' => 'Tranzacție actualizată cu succes',
        'update_failed' => 'O tranzacție nu a putut fi actualizată',
        'delete_success' => 'Tranzacție ștearsă cu succes',
        'delete_failed' => 'Tranzacția nu a putut fi ștearsă',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Conturi recuperate cu succes',
        'get_failed' => 'Conturile nu au putut fi recuperate',
        'not_found' => 'Contul nu a putut fi găsit',
        'create_success' => 'Cont creat cu succes',
        'create_error' => 'Contul nu a putut fi creat',
        'update_success' => 'Cont actualizat cu succes',
        'update_error' => 'Contul nu a putut fi actualizat',
        'delete_success' => 'Cont șters cu succes',
        'delete_error' => 'Contul nu a putut fi șters',
        'get_success' => 'Cont preluat cu succes',
        'get_error' => 'Contul nu a putut fi recuperat',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Factură preluată cu succes',
        'get_error' => 'Factura nu a putut fi recuperată',
        'create_success' => 'Factură creată cu succes',
        'create_error' => 'Factura nu a putut fi creată',
        'update_success' => 'Factură actualizată cu succes',
        'update_error' => 'Factura nu a putut fi actualizată',
        'delete_success' => 'Factură ștearsă cu succes',
        'delete_error' => 'Factura nu poate fi ștearsă cu succes',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documente preluate cu succes',
        'get_error' => 'Documentele nu au putut fi recuperate',
        'not_found' => 'Documentul nu a putut fi găsit',
        'create_failed' => 'Documentul nu a putut fi creat',
        'create_success' => 'Documentul a fost creat cu succes',
        'update_success' => 'Documentul a fost actualizat cu succes',
        'update_error' => 'Documentul nu a putut fi actualizat',
        'delete_failed' => 'Documentul nu a putut fi șters cu succes',
        'delete_success' => 'Document șters cu succes',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'Employee not found',
        'get_success' => 'Employees retrieved successfully',
        'get_failed' => 'Employees could not be retrieved',
        'create_success' => 'Employee created successfully',
        'create_failed' => 'A Employee could not be created',
        'update_success' => 'Employee updated successfully',
        'update_failed' => 'A Employee could not be updated',
        'delete_success' => 'Employee deleted successfully',
        'delete_failed' => 'A Employee could not be deleted',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Fișier preluat cu succes',
        'get_error' => 'Fișierul nu a putut fi preluat',
        'not_found' => 'Fișierul nu a putut fi găsit',
        'create_failed' => 'Fișierul nu a putut fi creat',
        'create_success' => 'Fișierul a fost creat cu succes',
        'update_success' => 'Fișierul a fost actualizat cu succes',
        'update_failed' => 'Fișierul nu a putut fi actualizat',
        'delete_failed' => 'Fișierul nu a putut fi șters cu succes',
        'delete_success' => 'Fișier șters cu succes',
        'get_success_folder' => 'Dosar preluat cu succes',
        'get_error_folder' => 'Dosarele nu au putut fi preluate',
        'not_found_folder' => 'Dosarul nu a putut fi găsit',
        'create_failed_folder' => 'Dosarul nu a putut fi creat',
        'create_success_folder' => 'Dosarul a fost creat cu succes',
        'update_success_folder' => 'Dosarul a fost actualizat cu succes',
        'update_failed_folder' => 'Dosarul nu a putut fi actualizat',
        'delete_failed_folder' => 'Dosarul nu a putut fi șters cu succes',
        'delete_success_folder' => 'Dosar șters cu succes',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Oferte recuperate cu succes',
        'get_failed' => 'Ofertele nu au putut fi recuperate',
        'not_found' => 'Oferta nu a putut fi găsită',
        'create_failed' => 'Oferta nu a putut fi creată',
        'create_success' => 'Oferta a fost creată cu succes',
        'convert_success' => 'Oferta a fost convertită în factură cu succes',
        'update_success' => 'Oferta a fost actualizată cu succes',
        'delete_success' => 'Oferta a fost ștearsă cu succes',
        'delete_failed' => 'Oferta nu a putut fi ștearsă',
        'update_failed' => 'Oferta nu a putut fi actualizată',
        'share_success' => 'Oferta a fost partajată cu succes',
        'share_failed' => 'Oferta nu a putut fi partajată',
        'accept_reject_success' => 'Oferta a fost respinsă cu succes',
        'send_success' => 'Oferta a fost trimisă cu succes',
        'send_failed' => 'Oferta nu a putut fi trimisă',
        'pdf_failed' => 'Generarea PDF a eșuat',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Facturi preluate cu succes',
        'get_failed' => 'Facturile nu au putut fi recuperate',
        'not_found' => 'Factura nu a putut fi găsită',
        'create_failed' => 'Factura nu a putut fi creată',
        'create_success' => 'Factura a fost creată cu succes',
        'delete_success' => 'Factura a fost ștearsă cu succes',
        'update_success' => 'Factura a fost actualizată cu succes',
        'share_success' => 'Factura a fost partajată cu succes',
        'share_failed' => 'Oferta nu a putut fi partajată',
        'send_success' => 'Factura a fost trimisă cu succes',
        'pdf_failed' => 'Generarea PDF a eșuat',
        'send_failed' => 'Factura nu a putut fi trimisă',
        'update_failed' => 'Factura nu a putut fi actualizată',
        'delete_failed' => 'Factura nu a putut fi ștearsă',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe nu este disponibil',
        'already_paid' => 'Factura a fost deja plătită',
        'invalid_key' => 'Cheie API nevalidă',
        'not_found' => 'Plata nu a putut fi găsită',
        'success' => 'Plata a fost reușită',
        'failed' => 'Plata a eșuat',
        'paypal_not_available' => 'Paypal nu este disponibil',
        'invoice' => 'Factură',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Utilizatorul nu a putut fi găsit',
        'update_success' => 'Utilizatorul a fost actualizat cu succes',
        'password_updated' => 'Parola a fost actualizată cu succes',
        'password_not_match' => 'Parola nu se potriveste',
        'password_empty' => 'Câmpul parolei este gol',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Țara este necesară',
        'not_enabled' => 'Open Banking nu este activată',
        'not_found' => 'Open Banking nu a fost găsită',
        'id_required' => 'ID-ul este necesar',
        'not_provided_infos' => 'Nu sunt informații furnizate',
        'requisition_success' => 'Solicitare reușită',
        'requisition_failed' => 'Solicitare eșuată',
        'session_id_required' => 'ID-ul sesiunii este necesar',
        'account_id_required' => 'ID-ul contului este necesar',
    ],

    'calendar' => [
        'get_success' => 'Eveniment preluat cu succes',
        'get_error' => 'Evenimentul nu a putut fi preluat',
        'not_found' => 'Evenimentul nu a putut fi găsit',
        'create_failed' => 'Evenimentul nu a putut fi creat',
        'create_success' => 'Evenimentul a fost creat cu succes',
        'update_success' => 'Evenimentul a fost actualizat cu succes',
        'update_failed' => 'Evenimentul nu a putut fi actualizat',
        'delete_failed' => 'Evenimentul nu a putut fi șters cu succes',
        'delete_success' => 'Eveniment șters cu succes',
    ],
    'department' => [
        'get_success' => 'Department retrieved successfully',
        'get_error' => 'Department could not be retrieved',
        'not_found' => 'Department could not be found',
        'create_failed' => 'Department could not be created',
        'create_success' => 'Department was created successfully',
        'update_success' => 'Department was updated successfully',
        'update_failed' => 'Department could not be updated',
        'delete_failed' => 'Department could  not be deleted successfully',
        'delete_success' => 'Department deleted successfully',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Factură',
    ],

    'dashboard' => [
        'income' => 'Venituri',
        'expense' => 'Cheltuială',
    ],

    'months' => [
        'january' => 'Ianuarie',
        'february' => 'Februarie',
        'march' => 'Martie',
        'april' => 'aprilie',
        'may' => 'Maj',
        'june' => 'Iunie',
        'july' => 'Iulie',
        'august' => 'august',
        'september' => 'Septembrie',
        'october' => 'Octombrie',
        'november' => 'Noiembrie',
        'december' => 'Decembrie',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rolul nu a putut fi găsit',
            'create_failed' => 'Rolul nu a putut fi creat',
            'create_success' => 'Rolul a fost creat cu succes',
            'update_success' => 'Rolul a fost actualizat cu succes',
            'delete_success' => 'Rolul a fost șters cu succes',
            'delete_failed' => 'Rolul nu a putut fi șters',
            'super_admin_cannot_be_created' => 'Rolul Super Administrator nu poate fi creat',
            'super_admin_cannot_be_updated' => 'Rolul Super Administrator nu poate fi actualizat',
            'super_admin_cannot_be_deleted' => 'Rolul de Super Administrator nu poate fi șters',
        ],
        'company_logo' => [
            'upload_success' => 'Logo-ul companiei a fost încărcat cu succes',
            'upload_failed' => 'Logo-ul companiei nu a putut fi încărcat',
            'remove_success' => 'Logo-ul companiei a fost șters cu succes',
            'remove_failed' => 'Logo-ul companiei nu a putut fi eliminat',
        ],
        'settings' => [
            'update_success' => 'Setările au fost actualizate cu succes',
            'update_failed' => 'Setările nu au putut fi actualizate',
        ],
        'currency' => [
            'not_found' => 'Moneda nu a putut fi găsită',
            'create_failed' => 'Moneda nu a putut fi creată',
            'create_success' => 'Moneda a fost creată cu succes',
            'update_success' => 'Moneda a fost actualizată cu succes',
            'delete_success' => 'Moneda a fost ștearsă cu succes',
            'delete_failed' => 'Moneda nu a putut fi ștearsă',
            'rates_updated' => 'Ratele au fost actualizate cu succes',
        ],
        'taxes' => [
            'not_found' => 'Taxa nu a putut fi găsită',
            'create_failed' => 'Taxa nu a putut fi creată',
            'create_success' => 'Taxa a fost creată cu succes',
            'update_success' => 'Taxa a fost actualizată cu succes',
            'delete_success' => 'Taxa a fost ștearsă cu succes',
            'delete_failed' => 'Taxa nu a putut fi ștearsă',
        ],

        'user' => [
            'not_found' => 'Utilizatorul nu a putut fi găsit',
            'create_failed' => 'Utilizatorul nu a putut fi creat',
            'create_success' => 'Utilizatorul a fost creat cu succes',
            'update_success' => 'Utilizatorul a fost actualizat cu succes',
            'update_failed' => 'Utilizatorul nu a putut fi actualizat',
            'delete_success' => 'Utilizatorul a fost șters cu succes',
            'delete_failed' => 'Utilizatorul nu a putut fi șters',
            'password_reset_success' => 'Parola a fost resetată cu succes',
            'password_reset_failed' => 'Parola nu a putut fi resetată',
            'delete_failed_self_account' => 'Nu vă puteți șterge propriul cont',
        ],
    ],
    'memory_used' => 'Memory used',
    'memory_available' => 'Memory available',
    'disk_used' => 'Disk used',
    'disk_available' => 'Disk available',
];
