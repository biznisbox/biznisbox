<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Hai effettuato l\'accesso con successo',
        'failed' => 'Accesso fallito',
    ],
    'logout' => [
        'success' => 'Ti sei disconnesso con successo',
        'failed' => 'Logout fallito',
    ],
    'auth' => [
        'failed' => 'Autenticazione non riuscita',
    ],
    'reset' => [
        'success' => 'Password reimpostata con successo',
        'failed' => 'Reimpostazione della password non riuscita',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Prodotto non trovato',
        'get_success' => 'Prodotti recuperati con successo',
        'get_failed' => 'Impossibile recuperare i prodotti',
        'create_success' => 'Prodotto creato con successo',
        'create_failed' => 'Impossibile creare un prodotto',
        'update_success' => 'Prodotto aggiornato con successo',
        'update_failed' => 'Un prodotto non può essere aggiornato',
        'delete_success' => 'Prodotto eliminato con successo',
        'delete_failed' => 'Un prodotto non può essere eliminato',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Partner non trovato',
        'get_success' => 'Partner recuperati con successo',
        'get_failed' => 'Impossibile recuperare i partner',
        'create_success' => 'Partner creato con successo',
        'create_failed' => 'Impossibile creare un partner',
        'update_success' => 'Partner aggiornato con successo',
        'update_failed' => 'Un partner non può essere aggiornato',
        'delete_success' => 'Partner eliminato con successo',
        'delete_failed' => 'Un partner non può essere eliminato',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transazione non trovata',
        'get_success' => 'Transazioni recuperate correttamente',
        'get_failed' => 'Impossibile recuperare le transazioni',
        'create_success' => 'Transazione creata con successo',
        'create_failed' => 'Impossibile creare una transazione',
        'update_success' => 'Transazione aggiornata con successo',
        'update_failed' => 'Una transazione non può essere aggiornata',
        'delete_success' => 'Transazione eliminata con successo',
        'delete_failed' => 'Una transazione non può essere eliminata',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Account recuperati con successo',
        'get_failed' => 'Impossibile recuperare gli account',
        'not_found' => 'Impossibile trovare l\'account',
        'create_success' => 'Account creato con successo',
        'create_error' => 'Impossibile creare l\'account',
        'update_success' => 'Account aggiornato con successo',
        'update_error' => 'L\'account non può essere aggiornato',
        'delete_success' => 'Account eliminato con successo',
        'delete_error' => 'L\'account non può essere eliminato',
        'get_success' => 'Account recuperato con successo',
        'get_error' => 'Impossibile recuperare l\'account',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Fattura recuperata con successo',
        'get_error' => 'Impossibile recuperare la bolletta',
        'create_success' => 'Fattura creata con successo',
        'create_error' => 'Impossibile creare la bolletta',
        'update_success' => 'Fattura aggiornata con successo',
        'update_error' => 'La bolletta non può essere aggiornata',
        'delete_success' => 'Fattura eliminata con successo',
        'delete_error' => 'La bolletta non può essere eliminata con successo',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documenti recuperati correttamente',
        'get_error' => 'Impossibile recuperare i documenti',
        'not_found' => 'Impossibile trovare il documento',
        'create_failed' => 'Impossibile creare il documento',
        'create_success' => 'Documento creato con successo',
        'update_success' => 'Documento aggiornato con successo',
        'update_error' => 'Il documento non può essere aggiornato',
        'delete_failed' => 'Il documento non può essere eliminato con successo',
        'delete_success' => 'Documento eliminato con successo',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'File recuperato con successo',
        'get_error' => 'Impossibile recuperare il file',
        'not_found' => 'Impossibile trovare il file',
        'create_failed' => 'Impossibile creare il file',
        'create_success' => 'File creato con successo',
        'update_success' => 'File aggiornato con successo',
        'update_failed' => 'Il file non può essere aggiornato',
        'delete_failed' => 'Il file non può essere eliminato con successo',
        'delete_success' => 'File eliminato con successo',
        'get_success_folder' => 'Cartella recuperata con successo',
        'get_error_folder' => 'Le cartelle non possono essere recuperate',
        'not_found_folder' => 'Impossibile trovare la cartella',
        'create_failed_folder' => 'Impossibile creare la cartella',
        'create_success_folder' => 'Cartella creata con successo',
        'update_success_folder' => 'Cartella aggiornata con successo',
        'update_failed_folder' => 'La cartella non può essere aggiornata',
        'delete_failed_folder' => 'La cartella non può essere eliminata correttamente',
        'delete_success_folder' => 'Cartella eliminata con successo',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Quotazioni recuperate con successo',
        'get_failed' => 'Non è stato possibile recuperare i preventivi',
        'not_found' => 'Il preventivo non è stato trovato',
        'create_failed' => 'Il preventivo non può essere creato',
        'create_success' => 'Il preventivo è stato creato con successo',
        'convert_success' => 'Il preventivo è stato convertito in fattura con successo',
        'update_success' => 'Il preventivo è stato aggiornato con successo',
        'delete_success' => 'Il preventivo è stato eliminato con successo',
        'delete_failed' => 'Il preventivo non può essere eliminato',
        'update_failed' => 'Il preventivo non può essere aggiornato',
        'share_success' => 'Preventivo condiviso con successo',
        'share_failed' => 'Il preventivo non può essere condiviso',
        'accept_reject_success' => 'Il preventivo è stato rifiutato con successo',
        'send_success' => 'Il preventivo è stato inviato con successo',
        'send_failed' => 'Il preventivo non può essere inviato',
        'pdf_failed' => 'Generazione PDF fallita',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Fatture recuperate correttamente',
        'get_failed' => 'Impossibile recuperare le fatture',
        'not_found' => 'Impossibile trovare la fattura',
        'create_failed' => 'Impossibile creare la fattura',
        'create_success' => 'Fattura creata con successo',
        'delete_success' => 'Fattura eliminata con successo',
        'update_success' => 'Fattura aggiornata con successo',
        'share_success' => 'Fattura condivisa con successo',
        'share_failed' => 'Il preventivo non può essere condiviso',
        'send_success' => 'Fattura inviata con successo',
        'pdf_failed' => 'Generazione PDF fallita',
        'send_failed' => 'Impossibile inviare la fattura',
        'update_failed' => 'La fattura non può essere aggiornata',
        'delete_failed' => 'La fattura non può essere eliminata',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Striscia non disponibile',
        'already_paid' => 'Fattura già pagata',
        'invalid_key' => 'Chiave API non valida',
        'not_found' => 'Impossibile trovare il pagamento',
        'success' => 'Pagamento riuscito',
        'failed' => 'Pagamento non riuscito',
        'paypal_not_available' => 'Paypal non disponibile',
        'invoice' => 'Fattura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Impossibile trovare l\'utente',
        'update_success' => 'L\'utente è stato aggiornato correttamente',
        'password_updated' => 'Password aggiornata con successo',
        'password_not_match' => 'La password non corrisponde',
        'password_empty' => 'Il campo password è vuoto',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Il paese è obbligatorio',
        'not_enabled' => 'Open Banking non è abilitato',
        'not_found' => 'Open Banking non trovato',
        'id_required' => 'ID richiesto',
        'not_provided_infos' => 'Informazioni non fornite',
        'requisition_success' => 'Successo della richiesta',
        'requisition_failed' => 'Requisito fallito',
        'session_id_required' => 'L\'ID della sessione è obbligatorio',
        'account_id_required' => 'L\'ID dell\'account è obbligatorio',
    ],

    'calendar' => [
        'get_success' => 'Evento recuperato correttamente',
        'get_error' => 'Impossibile recuperare l\'evento',
        'not_found' => 'Impossibile trovare l\'evento',
        'create_failed' => 'Impossibile creare l\'evento',
        'create_success' => 'Evento creato con successo',
        'update_success' => 'Evento aggiornato con successo',
        'update_failed' => 'L\'evento non può essere aggiornato',
        'delete_failed' => 'L\'evento non può essere eliminato con successo',
        'delete_success' => 'Evento eliminato con successo',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Fattura',
    ],

    'dashboard' => [
        'income' => 'Reddito',
        'expense' => 'Spese',
    ],

    'months' => [
        'january' => 'Gennaio',
        'february' => 'Febbraio',
        'march' => 'Marzo',
        'april' => 'Aprile',
        'may' => 'Maj',
        'june' => 'Giugno',
        'july' => 'Luglio',
        'august' => 'Agosto',
        'september' => 'Settembre',
        'october' => 'Ottobre',
        'november' => 'Novembre',
        'december' => 'Dicembre',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Impossibile trovare il ruolo',
            'create_failed' => 'Impossibile creare il ruolo',
            'create_success' => 'Ruolo creato con successo',
            'update_success' => 'Ruolo aggiornato con successo',
            'delete_success' => 'Ruolo eliminato con successo',
            'delete_failed' => 'Il ruolo non può essere eliminato',
            'super_admin_cannot_be_created' => 'Il ruolo Super Admin non può essere creato',
            'super_admin_cannot_be_updated' => 'Il ruolo Super Admin non può essere aggiornato',
            'super_admin_cannot_be_deleted' => 'Il ruolo Super Admin non può essere eliminato',
        ],
        'company_logo' => [
            'upload_success' => 'Logo dell\'azienda caricato con successo',
            'upload_failed' => 'Il logo dell\'azienda non può essere caricato',
            'remove_success' => 'Logo dell\'azienda rimosso con successo',
            'remove_failed' => 'Il logo dell\'azienda non può essere rimosso',
        ],
        'settings' => [
            'update_success' => 'Impostazioni aggiornate con successo',
            'update_failed' => 'Impossibile aggiornare le impostazioni',
        ],
        'currency' => [
            'not_found' => 'Impossibile trovare la valuta',
            'create_failed' => 'Impossibile creare la valuta',
            'create_success' => 'Valuta creata con successo',
            'update_success' => 'Valuta aggiornata con successo',
            'delete_success' => 'Valuta eliminata con successo',
            'delete_failed' => 'La valuta non può essere eliminata',
            'rates_updated' => 'Le tariffe sono state aggiornate con successo',
        ],
        'taxes' => [
            'not_found' => 'Impossibile trovare l\'imposta',
            'create_failed' => 'Impossibile creare l\'imposta',
            'create_success' => 'Imposta creata con successo',
            'update_success' => 'L\'imposta è stata aggiornata correttamente',
            'delete_success' => 'L\'imposta è stata eliminata con successo',
            'delete_failed' => 'La tassa non può essere eliminata',
        ],

        'user' => [
            'not_found' => 'Impossibile trovare l\'utente',
            'create_failed' => 'L\'utente non può essere creato',
            'create_success' => 'Utente creato con successo',
            'update_success' => 'L\'utente è stato aggiornato correttamente',
            'update_failed' => 'L\'utente non può essere aggiornato',
            'delete_success' => 'L\'utente è stato eliminato correttamente',
            'delete_failed' => 'L\'utente non può essere eliminato',
            'password_reset_success' => 'La password è stata reimpostata correttamente',
            'password_reset_failed' => 'La password non può essere reimpostata',
            'delete_failed_self_account' => 'Non puoi eliminare il tuo account',
        ],
    ],
];
