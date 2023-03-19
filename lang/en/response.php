<?php

return [
    // Auth responses
    'login' => [
        'success' => 'You have successfully logged in',
        'failed' => 'Login failed',
    ],
    'logout' => [
        'success' => 'You have successfully logged out',
        'failed' => 'Logout failed',
    ],
    'auth' => [
        'failed' => 'Authentication failed',
    ],
    'reset' => [
        'success' => 'Password reset successfully',
        'failed' => 'Password reset failed',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Product not found',
        'get_success' => 'Products retrieved successfully',
        'get_failed' => 'Products could not be retrieved',
        'create_success' => 'Product created successfully',
        'create_failed' => 'A product could not be created',
        'update_success' => 'Product updated successfully',
        'update_failed' => 'A product could not be updated',
        'delete_success' => 'Product deleted successfully',
        'delete_failed' => 'A product could not be deleted',
    ],

    // Vendor responses
    'vendor' => [
        'not_found' => 'Vendor not found',
        'get_success' => 'Vendors retrieved successfully',
        'get_failed' => 'Vendors could not be retrieved',
        'create_success' => 'Vendor created successfully',
        'create_failed' => 'A vendor could not be created',
        'update_success' => 'Vendor updated successfully',
        'update_failed' => 'A vendor could not be updated',
        'delete_success' => 'Vendor deleted successfully',
        'delete_failed' => 'A vendor could not be deleted',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transaction not found',
        'get_success' => 'Transactions retrieved successfully',
        'get_failed' => 'Transactions could not be retrieved',
        'create_success' => 'Transaction created successfully',
        'create_failed' => 'A transaction could not be created',
        'update_success' => 'Transaction updated successfully',
        'update_failed' => 'A transaction could not be updated',
        'delete_success' => 'Transaction deleted successfully',
        'delete_failed' => 'A transaction could not be deleted',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Accounts retrieved successfully',
        'get_failed' => 'Accounts could not be retrieved',
        'not_found' => 'Account could not be found',
        'create_success' => 'Account created successfully',
        'create_error' => 'Account could not be created',
        'update_success' => 'Account updated successfully',
        'update_error' => 'Account could not be updated',
        'delete_success' => 'Account deleted successfully',
        'delete_error' => 'Account could not be deleted',
        'get_success' => 'Account retrieved successfully',
        'get_error' => 'Account could not be retrieved',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Bill retrieved successfully',
        'get_error' => 'Bill could not be retrieved',
        'create_success' => 'Bill created successfully',
        'create_error' => 'Bill could not be created',
        'update_success' => 'Bill updated successfully',
        'update_error' => 'Bill could not be updated',
        'delete_success' => 'Bill deleted successfully',
        'delete_error' => 'Bill could not be deleted successfully',
    ],

    //Customer responses
    'customer' => [
        'get_success' => 'Customers retrieved successfully',
        'get_failed' => 'Customers could not be retrieved',
        'not_found' => 'Customer could not be found',
        'create_failed' => 'Customer could not be created',
        'create_success' => 'Customer was created successfully',
        'update_success' => 'Customer was updated successfully',
        'delete_success' => 'Customer deleted successfully',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documents retrieved successfully',
        'get_failed' => 'Documents could not be retrieved',
        'not_found' => 'Document could not be found',
        'create_failed' => 'Document could not be created',
        'create_success' => 'Document was created successfully',
        'delete_failed' => 'Document could  not be deleted successfully',
        'delete_success' => 'Customer deleted successfully',
    ],

    //Estimate responses
    'estimate' => [
        'get_success' => 'Estimates retrieved successfully',
        'get_failed' => 'Estimates could not be retrieved',
        'not_found' => 'Estimate could not be found',
        'create_failed' => 'Estimate could not be created',
        'create_success' => 'Estimate was created successfully',
        'convert_success' => 'Estimate was converted to invoice successfully',
        'update_success' => 'Estimate was updated successfully',
        'delete_success' => 'Estimate was deleted successfully',
        'delete_failed' => 'Estimate could not be deleted',
        'update_failed' => 'Estimate could not be updated',
        'share_success' => 'Estimate was shared successfully',
        'share_failed' => 'Estimate could not be shared',
        'accept_reject_success' => 'Estimate was rejected successfully',
        'send_success' => 'Estimate was sent successfully',
        'send_failed' => 'Estimate could not be sent',
        'pdf_failed' => 'Generating PDF failed',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Invoices retrieved successfully',
        'get_failed' => 'Invoices could not be retrieved',
        'not_found' => 'Invoice could not be found',
        'create_failed' => 'Invoice could not be created',
        'create_success' => 'Invoice was created successfully',
        'delete_success' => 'Invoice was deleted successfully',
        'update_success' => 'Invoice was updated successfully',
        'share_success' => 'Invoice was shared successfully',
        'share_failed' => 'Estimate could not be shared',
        'send_success' => 'Invoice was sent successfully',
        'pdf_failed' => 'Generating PDF failed',
        'send_failed' => 'Invoice could not be sent',
        'update_failed' => 'Invoice could not be updated',
        'delete_failed' => 'Invoice could not be deleted',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe is not available',
        'already_paid' => 'Invoice was already paid',
        'invalid_key' => 'Invalid API key',
        'not_found' => 'Payment could not be found',
        'success' => 'Payment was successful',
        'failed' => 'Payment failed',
        'paypal_not_available' => 'Paypal not available',
        'invoice' => 'Invoice',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'User could not be found',
        'update_success' => 'User was updated successfully',
        'password_updated' => 'Password was successfully updated',
        'password_not_match' => 'Password does not match',
        'password_empty' => 'Password field is empty',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Country is required',
        'not_enabled' => 'Open Banking is not enabled',
        'not_found' => 'Open Banking not found',
        'id_required' => 'ID is required',
        'not_provided_infos' => 'Not provided infos',
        'requisition_success' => 'Requisition success',
        'requisition_failed' => 'Requisition failed',
        'session_id_required' => 'Session ID is required',
        'account_id_required' => 'Account ID is required',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Invoice',
    ],

    'dashboard' => [
        'income' => 'Income',
        'expense' => 'Expense',
    ],

    'months' => [
        'january' => 'January',
        'february' => 'February',
        'march' => 'March',
        'april' => 'April',
        'may' => 'Maj',
        'june' => 'June',
        'july' => 'July',
        'august' => 'August',
        'september' => 'September',
        'october' => 'October',
        'november' => 'November',
        'december' => 'December',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Role could not be found',
            'create_failed' => 'Role could not be created',
            'create_success' => 'Role was created successfully',
            'update_success' => 'Role was updated successfully',
            'delete_success' => 'Role was deleted successfully',
            'delete_failed' => 'Role could not be deleted',
            'super_admin_cannot_be_created' => 'Super Admin role cannot be created',
            'super_admin_cannot_be_updated' => 'Super Admin role cannot be updated',
            'super_admin_cannot_be_deleted' => 'Super Admin role cannot be deleted',
        ],
        'settings' => [
            'update_success' => 'Settings were updated successfully',
            'update_failed' => 'Settings could not be updated',
        ],
        'currency' => [
            'not_found' => 'Currency could not be found',
            'create_failed' => 'Currency could not be created',
            'create_success' => 'Currency was created successfully',
            'update_success' => 'Currency was updated successfully',
            'delete_success' => 'Currency was deleted successfully',
            'delete_failed' => 'Currency could not be deleted',
            'rates_updated' => 'Rates were updated successfully',
        ],
        'taxes' => [
            'not_found' => 'Tax could not be found',
            'create_failed' => 'Tax could not be created',
            'create_success' => 'Tax was created successfully',
            'update_success' => 'Tax was updated successfully',
            'delete_success' => 'Tax was deleted successfully',
            'delete_failed' => 'Tax could not be deleted',
        ],

        'user' => [
            'not_found' => 'User could not be found',
            'create_failed' => 'User could not be created',
            'create_success' => 'User was created successfully',
            'update_success' => 'User was updated successfully',
            'update_failed' => 'User could not be updated',
            'delete_success' => 'User was deleted successfully',
            'delete_failed' => 'User could not be deleted',
            'password_reset_success' => 'Password was reset successfully',
            'password_reset_failed' => 'Password could not be reset',
            'delete_failed_self_account' => 'You cannot delete your own account',
        ],
    ],
];
