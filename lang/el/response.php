<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Έχετε συνδεθεί με επιτυχία',
        'failed' => 'Αποτυχία σύνδεσης',
    ],
    'logout' => [
        'success' => 'Έχετε αποσυνδεθεί με επιτυχία',
        'failed' => 'Η αποσύνδεση απέτυχε',
    ],
    'auth' => [
        'failed' => 'Αποτυχία ταυτοποίησης',
    ],
    'reset' => [
        'success' => 'Επιτυχής επαναφορά κωδικού πρόσβασης',
        'failed' => 'Αποτυχία επαναφοράς κωδικού πρόσβασης',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Το προϊόν δεν βρέθηκε',
        'get_success' => 'Τα προϊόντα ανακτήθηκαν με επιτυχία',
        'get_failed' => 'Δεν ήταν δυνατή η ανάκτηση προϊόντων',
        'create_success' => 'Το προϊόν δημιουργήθηκε με επιτυχία',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία ενός προϊόντος',
        'update_success' => 'Το προϊόν ενημερώθηκε επιτυχώς',
        'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση του προϊόντος',
        'delete_success' => 'Το προϊόν διαγράφηκε επιτυχώς',
        'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του προϊόντος',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Ο συνεργάτης δεν βρέθηκε',
        'get_success' => 'Οι συνεργάτες ανακτήθηκαν με επιτυχία',
        'get_failed' => 'Δεν ήταν δυνατή η ανάκτηση συνεργατών',
        'create_success' => 'Ο συνεργάτης δημιουργήθηκε με επιτυχία',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία Συνεργάτη',
        'update_success' => 'Ο συνεργάτης ενημερώθηκε επιτυχώς',
        'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση ενός Συνεργάτη',
        'delete_success' => 'Ο συνεργάτης διαγράφηκε επιτυχώς',
        'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή ενός συνεργάτη',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Η συναλλαγή δεν βρέθηκε',
        'get_success' => 'Οι συναλλαγές ανακτήθηκαν με επιτυχία',
        'get_failed' => 'Οι συναλλαγές δεν μπόρεσαν να ανακτηθούν',
        'create_success' => 'Η συναλλαγή δημιουργήθηκε με επιτυχία',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία μιας συναλλαγής',
        'update_success' => 'Η συναλλαγή ενημερώθηκε επιτυχώς',
        'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση μιας συναλλαγής',
        'delete_success' => 'Η συναλλαγή διαγράφηκε επιτυχώς',
        'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή μιας συναλλαγής',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Οι λογαριασμοί ανακτήθηκαν με επιτυχία',
        'get_failed' => 'Δεν ήταν δυνατή η ανάκτηση των λογαριασμών',
        'not_found' => 'Δεν ήταν δυνατή η εύρεση λογαριασμού',
        'create_success' => 'Ο λογαριασμός δημιουργήθηκε επιτυχώς',
        'create_error' => 'Δεν ήταν δυνατή η δημιουργία λογαριασμού',
        'update_success' => 'Ο λογαριασμός ενημερώθηκε επιτυχώς',
        'update_error' => 'Δεν ήταν δυνατή η ενημέρωση του λογαριασμού',
        'delete_success' => 'Ο λογαριασμός διαγράφηκε επιτυχώς',
        'delete_error' => 'Δεν ήταν δυνατή η διαγραφή του λογαριασμού',
        'get_success' => 'Ο λογαριασμός ανακτήθηκε επιτυχώς',
        'get_error' => 'Δεν ήταν δυνατή η ανάκτηση του λογαριασμού',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Ο λογαριασμός ανακτήθηκε με επιτυχία',
        'get_error' => 'Ο λογαριασμός δεν μπόρεσε να ανακτηθεί',
        'create_success' => 'Ο λογαριασμός δημιουργήθηκε με επιτυχία',
        'create_error' => 'Δεν ήταν δυνατή η δημιουργία λογαριασμού',
        'update_success' => 'Ο λογαριασμός ενημερώθηκε επιτυχώς',
        'update_error' => 'Δεν ήταν δυνατή η ενημέρωση του λογαριασμού',
        'delete_success' => 'Ο λογαριασμός διαγράφηκε επιτυχώς',
        'delete_error' => 'Ο λογαριασμός δεν μπόρεσε να διαγραφεί με επιτυχία',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Έγγραφα ανακτήθηκαν με επιτυχία',
        'get_error' => 'Δεν ήταν δυνατή η ανάκτηση εγγράφων',
        'not_found' => 'Το έγγραφο δεν βρέθηκε',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία εγγράφου',
        'create_success' => 'Το έγγραφο δημιουργήθηκε με επιτυχία',
        'update_success' => 'Έγγραφο ενημερώθηκε με επιτυχία',
        'update_error' => 'Δεν ήταν δυνατή η ενημέρωση του εγγράφου',
        'delete_failed' => 'Το έγγραφο δεν μπόρεσε να διαγραφεί με επιτυχία',
        'delete_success' => 'Το έγγραφο διαγράφηκε επιτυχώς',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Το αρχείο ανακτήθηκε επιτυχώς',
        'get_error' => 'Δεν ήταν δυνατή η ανάκτηση του αρχείου',
        'not_found' => 'Το αρχείο δεν βρέθηκε',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία αρχείου',
        'create_success' => 'Το αρχείο δημιουργήθηκε με επιτυχία',
        'update_success' => 'Το αρχείο ενημερώθηκε επιτυχώς',
        'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση του αρχείου',
        'delete_failed' => 'Το αρχείο δεν μπόρεσε να διαγραφεί επιτυχώς',
        'delete_success' => 'Το αρχείο διαγράφηκε επιτυχώς',
        'get_success_folder' => 'Ο φάκελος ανακτήθηκε επιτυχώς',
        'get_error_folder' => 'Δεν ήταν δυνατή η ανάκτηση των φακέλων',
        'not_found_folder' => 'Ο φάκελος δεν βρέθηκε',
        'create_failed_folder' => 'Δεν ήταν δυνατή η δημιουργία φακέλου',
        'create_success_folder' => 'Ο φάκελος δημιουργήθηκε με επιτυχία',
        'update_success_folder' => 'Ο φάκελος ενημερώθηκε με επιτυχία',
        'update_failed_folder' => 'Δεν ήταν δυνατή η ενημέρωση του φακέλου',
        'delete_failed_folder' => 'Ο φάκελος δεν μπόρεσε να διαγραφεί με επιτυχία',
        'delete_success_folder' => 'Ο φάκελος διαγράφηκε επιτυχώς',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Τα εισαγωγικά ανακτήθηκαν με επιτυχία',
        'get_failed' => 'Οι προσφορές δεν μπόρεσαν να ανακτηθούν',
        'not_found' => 'Η προσφορά δεν βρέθηκε',
        'create_failed' => 'Η προσφορά δεν μπόρεσε να δημιουργηθεί',
        'create_success' => 'Η προσφορά δημιουργήθηκε με επιτυχία',
        'convert_success' => 'Προσφορά μετατράπηκε σε τιμολόγιο με επιτυχία',
        'update_success' => 'Η προσφορά ενημερώθηκε με επιτυχία',
        'delete_success' => 'Η προσφορά διαγράφηκε με επιτυχία',
        'delete_failed' => 'Η προσφορά δεν μπορεί να διαγραφεί',
        'update_failed' => 'Η προσφορά δεν μπόρεσε να ενημερωθεί',
        'share_success' => 'Η προσφορά κοινοποιήθηκε με επιτυχία',
        'share_failed' => 'Η προσφορά δεν μπορεί να κοινοποιηθεί',
        'accept_reject_success' => 'Η προσφορά απορρίφθηκε με επιτυχία',
        'send_success' => 'Η προσφορά εστάλη με επιτυχία',
        'send_failed' => 'Η προσφορά δεν μπόρεσε να σταλεί',
        'pdf_failed' => 'Η δημιουργία PDF απέτυχε',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Επιτυχής ανάκτηση τιμολογίων',
        'get_failed' => 'Τα τιμολόγια δεν μπόρεσαν να ανακτηθούν',
        'not_found' => 'Το τιμολόγιο δεν βρέθηκε',
        'create_failed' => 'Το τιμολόγιο δεν μπόρεσε να δημιουργηθεί',
        'create_success' => 'Το τιμολόγιο δημιουργήθηκε με επιτυχία',
        'delete_success' => 'Το τιμολόγιο διαγράφηκε με επιτυχία',
        'update_success' => 'Το τιμολόγιο ενημερώθηκε με επιτυχία',
        'share_success' => 'Το τιμολόγιο κοινοποιήθηκε με επιτυχία',
        'share_failed' => 'Η προσφορά δεν μπορεί να κοινοποιηθεί',
        'send_success' => 'Το τιμολόγιο εστάλη επιτυχώς',
        'pdf_failed' => 'Η δημιουργία PDF απέτυχε',
        'send_failed' => 'Δεν ήταν δυνατή η αποστολή τιμολογίου',
        'update_failed' => 'Το τιμολόγιο δεν μπόρεσε να ενημερωθεί',
        'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του τιμολογίου',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Το Stripe δεν είναι διαθέσιμο',
        'already_paid' => 'Το τιμολόγιο έχει ήδη πληρωθεί',
        'invalid_key' => 'Μη έγκυρο κλειδί API',
        'not_found' => 'Δεν ήταν δυνατή η εύρεση πληρωμής',
        'success' => 'Η πληρωμή ήταν επιτυχής',
        'failed' => 'Η πληρωμή απέτυχε',
        'paypal_not_available' => 'Paypal δεν είναι διαθέσιμο',
        'invoice' => 'Τιμολόγιο',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Δεν ήταν δυνατή η εύρεση του χρήστη',
        'update_success' => 'Ο χρήστης ενημερώθηκε με επιτυχία',
        'password_updated' => 'Ο κωδικός πρόσβασης ενημερώθηκε επιτυχώς',
        'password_not_match' => 'Ο κωδικός πρόσβασης δεν ταιριάζει',
        'password_empty' => 'Το πεδίο κωδικού πρόσβασης είναι κενό',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Η χώρα απαιτείται',
        'not_enabled' => 'Το Open Banking δεν είναι ενεργοποιημένο',
        'not_found' => 'Το Open Banking δεν βρέθηκε',
        'id_required' => 'Το ID απαιτείται',
        'not_provided_infos' => 'Δεν παρέχονται πληροφορίες',
        'requisition_success' => 'Επιτυχής απόκτηση',
        'requisition_failed' => 'Αποτυχία απόκτησης',
        'session_id_required' => 'Απαιτείται ID συνεδρίας',
        'account_id_required' => 'Απαιτείται ID λογαριασμού',
    ],

    'calendar' => [
        'get_success' => 'Το συμβάν ανακτήθηκε επιτυχώς',
        'get_error' => 'Δεν ήταν δυνατή η ανάκτηση του συμβάντος',
        'not_found' => 'Δεν βρέθηκε το συμβάν',
        'create_failed' => 'Δεν ήταν δυνατή η δημιουργία συμβάντος',
        'create_success' => 'Το συμβάν δημιουργήθηκε με επιτυχία',
        'update_success' => 'Η εκδήλωση ενημερώθηκε με επιτυχία',
        'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση της εκδήλωσης',
        'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του συμβάντος με επιτυχία',
        'delete_success' => 'Το συμβάν διαγράφηκε επιτυχώς',
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
        'invoice_subject' => 'Τιμολόγιο',
    ],

    'dashboard' => [
        'income' => 'Έσοδα',
        'expense' => 'Έξοδα',
    ],

    'months' => [
        'january' => 'Ιανουάριος',
        'february' => 'Φεβρουάριος',
        'march' => 'Μάρτιος',
        'april' => 'Απριλίου',
        'may' => 'Maj',
        'june' => 'Ιουνίου',
        'july' => 'Ιούλιος',
        'august' => 'Αύγουστος',
        'september' => 'Σεπτέμβριος',
        'october' => 'Οκτώβριος',
        'november' => 'Νοέμβριος',
        'december' => 'Δεκέμβριος',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Ο ρόλος δεν βρέθηκε',
            'create_failed' => 'Ο ρόλος δεν μπορεί να δημιουργηθεί',
            'create_success' => 'Ο ρόλος δημιουργήθηκε με επιτυχία',
            'update_success' => 'Ο ρόλος ενημερώθηκε με επιτυχία',
            'delete_success' => 'Ο ρόλος διαγράφηκε με επιτυχία',
            'delete_failed' => 'Ο ρόλος δεν μπορεί να διαγραφεί',
            'super_admin_cannot_be_created' => 'Ο ρόλος Super Admin δεν μπορεί να δημιουργηθεί',
            'super_admin_cannot_be_updated' => 'Ο ρόλος Super Admin δεν μπορεί να ενημερωθεί',
            'super_admin_cannot_be_deleted' => 'Ο ρόλος Super Admin δεν μπορεί να διαγραφεί',
        ],
        'company_logo' => [
            'upload_success' => 'Το λογότυπο της εταιρείας μεταφορτώθηκε με επιτυχία',
            'upload_failed' => 'Το λογότυπο της εταιρείας δεν μπόρεσε να μεταφορτωθεί',
            'remove_success' => 'Το λογότυπο της εταιρείας αφαιρέθηκε με επιτυχία',
            'remove_failed' => 'Το λογότυπο της εταιρείας δεν μπορεί να αφαιρεθεί',
        ],
        'settings' => [
            'update_success' => 'Οι ρυθμίσεις ενημερώθηκαν με επιτυχία',
            'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση των ρυθμίσεων',
        ],
        'currency' => [
            'not_found' => 'Δεν ήταν δυνατή η εύρεση νομίσματος',
            'create_failed' => 'Δεν ήταν δυνατή η δημιουργία νομίσματος',
            'create_success' => 'Το νόμισμα δημιουργήθηκε με επιτυχία',
            'update_success' => 'Νόμισμα ενημερώθηκε με επιτυχία',
            'delete_success' => 'Νόμισμα διαγράφηκε με επιτυχία',
            'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του νομίσματος',
            'rates_updated' => 'Οι τιμές ενημερώθηκαν με επιτυχία',
        ],
        'taxes' => [
            'not_found' => 'Δεν ήταν δυνατή η εύρεση φόρου',
            'create_failed' => 'Δεν ήταν δυνατή η δημιουργία φόρου',
            'create_success' => 'Φόρος δημιουργήθηκε με επιτυχία',
            'update_success' => 'Φόρος ενημερώθηκε με επιτυχία',
            'delete_success' => 'Ο φόρος διαγράφηκε με επιτυχία',
            'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του φόρου',
        ],

        'user' => [
            'not_found' => 'Δεν ήταν δυνατή η εύρεση του χρήστη',
            'create_failed' => 'Ο χρήστης δεν μπόρεσε να δημιουργηθεί',
            'create_success' => 'Ο χρήστης δημιουργήθηκε με επιτυχία',
            'update_success' => 'Ο χρήστης ενημερώθηκε με επιτυχία',
            'update_failed' => 'Δεν ήταν δυνατή η ενημέρωση του χρήστη',
            'delete_success' => 'Ο χρήστης διαγράφηκε με επιτυχία',
            'delete_failed' => 'Δεν ήταν δυνατή η διαγραφή του χρήστη',
            'password_reset_success' => 'Επιτυχής επαναφορά κωδικού πρόσβασης',
            'password_reset_failed' => 'Αδυναμία επαναφοράς του κωδικού πρόσβασης',
            'delete_failed_self_account' => 'Δεν μπορείτε να διαγράψετε τον δικό σας λογαριασμό',
        ],
    ],
    'memory_used' => 'Memory used',
    'memory_available' => 'Memory available',
    'disk_used' => 'Disk used',
    'disk_available' => 'Disk available',
];