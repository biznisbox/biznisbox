<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Vous vous êtes connecté avec succès',
        'failed' => 'Échec de la connexion',
    ],
    'logout' => [
        'success' => 'Vous vous êtes déconnecté avec succès',
        'failed' => 'Échec de la déconnexion',
    ],
    'auth' => [
        'failed' => 'Échec de l\'authentification',
    ],
    'reset' => [
        'success' => 'Mot de passe réinitialisé avec succès',
        'failed' => 'La réinitialisation du mot de passe a échoué',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produit introuvable',
        'get_success' => 'Produits récupérés avec succès',
        'get_failed' => 'Les produits n\'ont pas pu être récupérés',
        'create_success' => 'Produit créé avec succès',
        'create_failed' => 'Un produit n\'a pas pu être créé',
        'update_success' => 'Produit mis à jour avec succès',
        'update_failed' => 'Un produit n\'a pas pu être mis à jour',
        'delete_success' => 'Produit supprimé avec succès',
        'delete_failed' => 'Un produit n\'a pas pu être supprimé',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Partenaire introuvable',
        'get_success' => 'Partenaires récupérés avec succès',
        'get_failed' => 'Les partenaires n\'ont pas pu être récupérés',
        'create_success' => 'Partenaire créé avec succès',
        'create_failed' => 'Un partenaire n\'a pas pu être créé',
        'update_success' => 'Partenaire mis à jour avec succès',
        'update_failed' => 'Un partenaire n\'a pas pu être mis à jour',
        'delete_success' => 'Partenaire supprimé avec succès',
        'delete_failed' => 'Un partenaire n\'a pas pu être supprimé',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaction introuvable',
        'get_success' => 'Transactions récupérées avec succès',
        'get_failed' => 'Les transactions n\'ont pas pu être récupérées',
        'create_success' => 'Transaction créée avec succès',
        'create_failed' => 'Une transaction n\'a pas pu être créée',
        'update_success' => 'Transaction mise à jour avec succès',
        'update_failed' => 'Une transaction n\'a pas pu être mise à jour',
        'delete_success' => 'Transaction supprimée avec succès',
        'delete_failed' => 'Une transaction n\'a pas pu être supprimée',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Comptes récupérés avec succès',
        'get_failed' => 'Les comptes n\'ont pas pu être récupérés',
        'not_found' => 'Le compte est introuvable',
        'create_success' => 'Compte créé avec succès',
        'create_error' => 'Le compte n\'a pas pu être créé',
        'update_success' => 'Compte mis à jour avec succès',
        'update_error' => 'Le compte n\'a pas pu être mis à jour',
        'delete_success' => 'Compte supprimé avec succès',
        'delete_error' => 'Le compte n\'a pas pu être supprimé',
        'get_success' => 'Compte récupéré avec succès',
        'get_error' => 'Le compte n\'a pas pu être récupéré',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Facture récupérée avec succès',
        'get_error' => 'La facture n\'a pas pu être récupérée',
        'create_success' => 'Facture créée avec succès',
        'create_error' => 'La facture n\'a pas pu être créée',
        'update_success' => 'Facture mise à jour avec succès',
        'update_error' => 'La facture n\'a pas pu être mise à jour',
        'delete_success' => 'Facture supprimée avec succès',
        'delete_error' => 'La facture n\'a pas pu être supprimée avec succès',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documents récupérés avec succès',
        'get_error' => 'Les documents n\'ont pas pu être récupérés',
        'not_found' => 'Le document est introuvable',
        'create_failed' => 'Le document n\'a pas pu être créé',
        'create_success' => 'Le document a bien été créé',
        'update_success' => 'Le document a bien été mis à jour',
        'update_error' => 'Le document n\'a pas pu être mis à jour',
        'delete_failed' => 'Le document n\'a pas pu être supprimé avec succès',
        'delete_success' => 'Document supprimé avec succès',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Fichier récupéré avec succès',
        'get_error' => 'Le fichier n\'a pas pu être récupéré',
        'not_found' => 'Le fichier est introuvable',
        'create_failed' => 'Le fichier n\'a pas pu être créé',
        'create_success' => 'Le fichier a été créé avec succès',
        'update_success' => 'Le fichier a bien été mis à jour',
        'update_failed' => 'Le fichier n\'a pas pu être mis à jour',
        'delete_failed' => 'Le fichier n\'a pas pu être supprimé avec succès',
        'delete_success' => 'Fichier supprimé avec succès',
        'get_success_folder' => 'Dossier récupéré avec succès',
        'get_error_folder' => 'Les dossiers n\'ont pas pu être récupérés',
        'not_found_folder' => 'Le dossier est introuvable',
        'create_failed_folder' => 'Le dossier n\'a pas pu être créé',
        'create_success_folder' => 'Le dossier a été créé avec succès',
        'update_success_folder' => 'Le dossier a été mis à jour avec succès',
        'update_failed_folder' => 'Le dossier n\'a pas pu être mis à jour',
        'delete_failed_folder' => 'Le dossier n\'a pas pu être supprimé avec succès',
        'delete_success_folder' => 'Dossier supprimé avec succès',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Devis récupérés avec succès',
        'get_failed' => 'Les devis n\'ont pas pu être récupérés',
        'not_found' => 'Le devis est introuvable',
        'create_failed' => 'Le devis n\'a pas pu être créé',
        'create_success' => 'Le devis a bien été créé',
        'convert_success' => 'Le devis a été converti en facture avec succès',
        'update_success' => 'Le devis a bien été mis à jour',
        'delete_success' => 'Le devis a bien été supprimé',
        'delete_failed' => 'Le devis n\'a pas pu être supprimé',
        'update_failed' => 'Le devis n\'a pas pu être mis à jour',
        'share_success' => 'Le devis a bien été partagé',
        'share_failed' => 'Le devis n\'a pas pu être partagé',
        'accept_reject_success' => 'Le devis a été rejeté avec succès',
        'send_success' => 'Le devis a bien été envoyé',
        'send_failed' => 'Le devis n\'a pas pu être envoyé',
        'pdf_failed' => 'La génération du PDF a échoué',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Factures récupérées avec succès',
        'get_failed' => 'Les factures n\'ont pas pu être récupérées',
        'not_found' => 'Facture introuvable',
        'create_failed' => 'La facture n\'a pas pu être créée',
        'create_success' => 'La facture a été créée avec succès',
        'delete_success' => 'La facture a été supprimée avec succès',
        'update_success' => 'La facture a été mise à jour avec succès',
        'share_success' => 'La facture a été partagée avec succès',
        'share_failed' => 'Le devis n\'a pas pu être partagé',
        'send_success' => 'La facture a été envoyée avec succès',
        'pdf_failed' => 'La génération du PDF a échoué',
        'send_failed' => 'La facture n\'a pas pu être envoyée',
        'update_failed' => 'La facture n\'a pas pu être mise à jour',
        'delete_failed' => 'La facture n\'a pas pu être supprimée',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe n\'est pas disponible',
        'already_paid' => 'La facture a déjà été payée',
        'invalid_key' => 'Clé API invalide',
        'not_found' => 'Le paiement est introuvable',
        'success' => 'Paiement réussi',
        'failed' => 'Le paiement a échoué',
        'paypal_not_available' => 'Paypal non disponible',
        'invoice' => 'Facture',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'L\'utilisateur est introuvable',
        'update_success' => 'L\'utilisateur a été mis à jour avec succès',
        'password_updated' => 'Le mot de passe a bien été mis à jour',
        'password_not_match' => 'Le mot de passe ne correspond pas',
        'password_empty' => 'Le champ mot de passe est vide',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Le pays est requis',
        'not_enabled' => 'L\'Open Banking n\'est pas activé',
        'not_found' => 'Les services bancaires ouverts sont introuvables',
        'id_required' => 'L\'identifiant est requis',
        'not_provided_infos' => 'Information non fournie',
        'requisition_success' => 'Récupération réussie',
        'requisition_failed' => 'La réquisition a échoué',
        'session_id_required' => 'L\'ID de session est requis',
        'account_id_required' => 'L\'ID du compte est requis',
    ],

    'calendar' => [
        'get_success' => 'Événement récupéré avec succès',
        'get_error' => 'L\'événement n\'a pas pu être récupéré',
        'not_found' => 'L\'événement est introuvable',
        'create_failed' => 'L\'événement n\'a pas pu être créé',
        'create_success' => 'L\'événement a été créé avec succès',
        'update_success' => 'L\'événement a été mis à jour avec succès',
        'update_failed' => 'L\'événement n\'a pas pu être mis à jour',
        'delete_failed' => 'L\'événement n\'a pas pu être supprimé avec succès',
        'delete_success' => 'Événement supprimé avec succès',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Facture',
    ],

    'dashboard' => [
        'income' => 'Revenu',
        'expense' => 'Dépenses',
    ],

    'months' => [
        'january' => 'Janvier',
        'february' => 'Février',
        'march' => 'Marche',
        'april' => 'Avril',
        'may' => 'Maj',
        'june' => 'Juin',
        'july' => 'Juillet',
        'august' => 'Août',
        'september' => 'Septembre',
        'october' => 'Octobre',
        'november' => 'Novembre',
        'december' => 'Décembre',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Rôle introuvable',
            'create_failed' => 'Le rôle n\'a pas pu être créé',
            'create_success' => 'Le rôle a été créé avec succès',
            'update_success' => 'Le rôle a été mis à jour avec succès',
            'delete_success' => 'Le rôle a été supprimé avec succès',
            'delete_failed' => 'Le rôle n\'a pas pu être supprimé',
            'super_admin_cannot_be_created' => 'Le rôle Super Admin ne peut pas être créé',
            'super_admin_cannot_be_updated' => 'Le rôle Super Admin ne peut pas être mis à jour',
            'super_admin_cannot_be_deleted' => 'Le rôle Super Admin ne peut pas être supprimé',
        ],
        'company_logo' => [
            'upload_success' => 'Le logo de la société a été téléchargé avec succès',
            'upload_failed' => 'Le logo de l\'entreprise n\'a pas pu être téléchargé',
            'remove_success' => 'Le logo de la société a été supprimé avec succès',
            'remove_failed' => 'Le logo de l\'entreprise n\'a pas pu être supprimé',
        ],
        'settings' => [
            'update_success' => 'Les paramètres ont été mis à jour avec succès',
            'update_failed' => 'Les paramètres n\'ont pas pu être mis à jour',
        ],
        'currency' => [
            'not_found' => 'La devise n\'a pas pu être trouvée',
            'create_failed' => 'La devise n\'a pas pu être créée',
            'create_success' => 'La devise a été créée avec succès',
            'update_success' => 'La devise a été mise à jour avec succès',
            'delete_success' => 'La devise a été supprimée avec succès',
            'delete_failed' => 'La devise n\'a pas pu être supprimée',
            'rates_updated' => 'Les tarifs ont été mis à jour avec succès',
        ],
        'taxes' => [
            'not_found' => 'La taxe est introuvable',
            'create_failed' => 'La taxe n\'a pas pu être créée',
            'create_success' => 'La taxe a été créée avec succès',
            'update_success' => 'La taxe a bien été mise à jour',
            'delete_success' => 'La taxe a été supprimée avec succès',
            'delete_failed' => 'La taxe n\'a pas pu être supprimée',
        ],

        'user' => [
            'not_found' => 'L\'utilisateur est introuvable',
            'create_failed' => 'L\'utilisateur n\'a pas pu être créé',
            'create_success' => 'L\'utilisateur a été créé avec succès',
            'update_success' => 'L\'utilisateur a été mis à jour avec succès',
            'update_failed' => 'L\'utilisateur n\'a pas pu être mis à jour',
            'delete_success' => 'L\'utilisateur a été supprimé avec succès',
            'delete_failed' => 'L\'utilisateur n\'a pas pu être supprimé',
            'password_reset_success' => 'Mot de passe a été réinitialisé avec succès',
            'password_reset_failed' => 'Le mot de passe n\'a pas pu être réinitialisé',
            'delete_failed_self_account' => 'Vous ne pouvez pas supprimer votre propre compte',
        ],
    ],
];
