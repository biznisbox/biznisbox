<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OpenBankingController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\PermissionRoleController as AdminPermissionRoleController;
use App\Http\Controllers\Admin\TaxController as AdminTaxController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\CurrencyController as AdminCurrencyController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\Admin\WebhookSubscriptionController as AdminWebhookSubscriptionController;
use App\Http\Controllers\Admin\DashboardDataController as AdminDashboardDataController;
use App\Http\Controllers\Client\InvoiceController as ClientInvoiceController;
use App\Http\Controllers\Client\QuoteController as ClientQuoteController;
use App\Http\Controllers\Client\SupportTicketController as ClientSupportTicketController;
use App\Http\Controllers\Client\ContractController as ClientContractController;
use App\Http\Controllers\Install\InstallerController;
use App\Http\Middleware\CheckIfInstalled;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'Login'])->name('login');
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/refresh', [AuthController::class, 'Refresh'])->name('refresh');
    Route::get('/data', [DataController::class, 'getData'])->name('getData');
    Route::get('/me', [AuthController::class, 'Me'])->name('me'); // Get current user data
    Route::get('/logs', [DataController::class, 'getLogs'])->name('getLogs');

    // Category routes
    Route::get('/categories', [DataController::class, 'getCategories'])->name('getCategories');
    Route::get('/categories/{id}', [DataController::class, 'getCategory'])->name('getCategory');
    Route::post('/categories', [DataController::class, 'createCategory'])->name('createCategory');
    Route::put('/categories/{id}', [DataController::class, 'updateCategory'])->name('updateCategory');
    Route::delete('/categories/{id}', [DataController::class, 'deleteCategory'])->name('deleteCategory');

    // Profile
    Route::post('/profile/theme', [ProfileController::class, 'changeTheme'])->name('changeTheme');
    Route::get('/profile', [ProfileController::class, 'getProfile'])->name('getProfile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/profile/2fa', [ProfileController::class, 'set2FactorAuth'])->name('set2FactorAuth');
    Route::delete('/profile/2fa', [ProfileController::class, 'disable2FactorAuth'])->name('disable2FactorAuth');
    Route::post('/profile/2fa/verify', [ProfileController::class, 'enable2FactorAuth'])->name('enable2FactorAuth');
    Route::post('/profile/avatar', [ProfileController::class, 'setProfilePicture'])->name('setProfilePicture');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteProfilePicture'])->name('deleteProfilePicture');

    // Notification
    Route::get('/notifications', [ProfileController::class, 'getCurrentUserNotifications'])->name('getCurrentUserNotifications');
    Route::post('/notifications/{id}', [ProfileController::class, 'markNotificationAsRead'])->name('markNotificationAsRead');
    Route::delete('/notifications/{id}', [ProfileController::class, 'deleteNotification'])->name('deleteNotification');

    // Dashboard Layout
    Route::get('/dashboard', [DataController::class, 'getDashboardLayout'])->name('getDashboardLayout');
    Route::post('/dashboard', [DataController::class, 'updateDashboardLayout'])->name('updateDashboardLayout');

    // Dashboard Data
    Route::get('/dashboard/data', [DataController::class, 'getDashboardData'])->name('getDashboardData');

    // Product
    Route::group(['middleware' => 'can:products'], function () {
        Route::post('/products', [ProductController::class, 'createProduct'])->name('createProduct');
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
        Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        Route::get('/products', [ProductController::class, 'getProducts'])->name('getProducts');
        Route::get('/products/{id}', [ProductController::class, 'getProduct'])->name('getProduct');
        Route::get('/product/number', [ProductController::class, 'getProductNumber'])->name('getProductNumber');
    });

    // Partner
    Route::group(['middleware' => 'can:partners'], function () {
        Route::post('/partners', [PartnerController::class, 'createPartner'])->name('createPartner');
        Route::post('/partners/activity', [PartnerController::class, 'createPartnerActivity'])->name('createPartnerActivity');
        Route::put('/partners/activity/{id}', [PartnerController::class, 'updatePartnerActivity'])->name('updatePartnerActivity');
        Route::delete('/partners/activity/{id}', [PartnerController::class, 'deletePartnerActivity'])->name('deletePartnerActivity');
        Route::put('/partners/{id}', [PartnerController::class, 'updatePartner'])->name('updatePartner');
        Route::delete('/partners/{id}', [PartnerController::class, 'deletePartner'])->name('deletePartner');
        Route::get('/partners', [PartnerController::class, 'getPartners'])->name('getPartners');
        Route::get('/partners/{id}', [PartnerController::class, 'getPartner'])->name('getPartner');
        Route::get('/partner/number', [PartnerController::class, 'getPartnerNumber'])->name('getPartnerNumber');
    });

    // Partner Limited is for the other users who can't access all the partners -> used in the other parts of the app
    Route::get('/partner/limited', [PartnerController::class, 'getPartnersLimitedData'])->name('getPartnersLimitedData');

    // Calendar
    Route::group(['prefix' => 'calendar', 'middleware' => 'can:calendar'], function () {
        Route::post('/events', [CalendarController::class, 'createEvent'])->name('createEvent');
        Route::put('/events/{id}', [CalendarController::class, 'updateEvent'])->name('updateEvent');
        Route::delete('/events/{id}', [CalendarController::class, 'deleteEvent'])->name('deleteEvent');
        Route::get('/events', [CalendarController::class, 'getEvents'])->name('getEvents');
        Route::get('/events/{id}', [CalendarController::class, 'getEvent'])->name('getEvent');
    });

    // Invoice
    Route::group(['middleware' => 'can:invoices'], function () {
        Route::get('/invoices', [InvoiceController::class, 'getInvoices'])->name('getInvoices');
        Route::get('/invoices/{id}', [InvoiceController::class, 'getInvoice'])->name('getInvoice');
        Route::post('/invoices', [InvoiceController::class, 'createInvoice'])->name('createInvoice');
        Route::put('/invoices/{id}', [InvoiceController::class, 'updateInvoice'])->name('updateInvoice');
        Route::delete('/invoices/{id}', [InvoiceController::class, 'deleteInvoice'])->name('deleteInvoice');
        Route::get('/invoice/number', [InvoiceController::class, 'getInvoiceNumber'])->name('getInvoiceNumber');
        Route::get('/invoice/{id}/share/', [InvoiceController::class, 'shareInvoice'])->name('shareInvoice');
        Route::post('/invoice/{id}/send', [InvoiceController::class, 'sendInvoiceNotification'])->name('sendInvoiceNotification');
        Route::post('/invoice/{id}/payment', [InvoiceController::class, 'addInvoicePayment'])->name('addInvoicePayment');
    });

    // Quote
    Route::group(['middleware' => 'can:quotes'], function () {
        Route::get('/quotes', [QuoteController::class, 'getQuotes'])->name('getQuotes');
        Route::get('/quotes/{id}', [QuoteController::class, 'getQuote'])->name('getQuote');
        Route::post('/quotes', [QuoteController::class, 'createQuote'])->name('createQuote');
        Route::put('/quotes/{id}', [QuoteController::class, 'updateQuote'])->name('updateQuote');
        Route::delete('/quotes/{id}', [QuoteController::class, 'deleteQuote'])->name('deleteQuote');
        Route::get('/quote/number', [QuoteController::class, 'getQuoteNumber'])->name('getQuoteNumber');
        Route::get('/quote/share/{id}', [QuoteController::class, 'shareQuote'])->name('shareQuote');
        Route::get('/quote/convert/{id}', [QuoteController::class, 'convertQuoteToInvoice'])->name('convertQuoteToInvoice');
        Route::post('/quote/{id}/send', [QuoteController::class, 'sendQuoteNotification'])->name('sendQuoteNotification');
    });

    // Employee
    Route::group(['middleware' => 'can:employees'], function () {
        Route::get('/employees', [EmployeeController::class, 'getEmployees'])->name('getEmployees');
        Route::get('/employees/{id}', [EmployeeController::class, 'getEmployee'])->name('getEmployee');
        Route::post('/employees', [EmployeeController::class, 'createEmployee'])->name('createEmployee');
        Route::put('/employees/{id}', [EmployeeController::class, 'updateEmployee'])->name('updateEmployee');
        Route::delete('/employees/{id}', [EmployeeController::class, 'deleteEmployee'])->name('deleteEmployee');
        Route::get('/employee/number', [EmployeeController::class, 'getEmployeeNumber'])->name('getEmployeeNumber');
    });

    // Bill
    Route::group(['middleware' => 'can:bills'], function () {
        Route::get('/bills', [BillController::class, 'getBills'])->name('getBills');
        Route::get('/bills/{id}', [BillController::class, 'getBill'])->name('getBill');
        Route::post('/bills', [BillController::class, 'createBill'])->name('createBill');
        Route::put('/bills/{id}', [BillController::class, 'updateBill'])->name('updateBill');
        Route::delete('/bills/{id}', [BillController::class, 'deleteBill'])->name('deleteBill');
        Route::get('/bill/number', [BillController::class, 'getBillNumber'])->name('getBillNumber');
    });

    // Account
    Route::group(['middleware' => 'can:accounts'], function () {
        Route::get('/accounts', [AccountController::class, 'getAccounts'])->name('getAccounts');
        Route::get('/accounts/{id}', [AccountController::class, 'getAccount'])->name('getAccount');
        Route::post('/accounts', [AccountController::class, 'createAccount'])->name('createAccount');
        Route::put('/accounts/{id}', [AccountController::class, 'updateAccount'])->name('updateAccount');
        Route::delete('/accounts/{id}', [AccountController::class, 'deleteAccount'])->name('deleteAccount');
    });

    // Open Banking
    Route::group(['middleware' => 'can:open_banking'], function () {
        Route::get('/open-banking/countries', [OpenBankingController::class, 'listAvailableCountries'])->name('listAvailableCountries');
        Route::get('/open-banking/banks', [OpenBankingController::class, 'listBanks'])->name('listBanks');
        Route::post('/open-banking/session', [OpenBankingController::class, 'initSession'])->name('initSession');
        Route::post('/open-banking/account', [OpenBankingController::class, 'createOpenBankingAccount'])->name('createOpenBankingAccount');
    });

    // Transaction

    Route::group(['middleware' => 'can:transactions'], function () {
        Route::get('/transactions', [TransactionController::class, 'getTransactions'])->name('getTransactions');
        Route::get('/transactions/{id}', [TransactionController::class, 'getTransaction'])->name('getTransaction');
        Route::post('/transactions', [TransactionController::class, 'createTransaction'])->name('createTransaction');
        Route::put('/transactions/{id}', [TransactionController::class, 'updateTransaction'])->name('updateTransaction');
        Route::delete('/transactions/{id}', [TransactionController::class, 'deleteTransaction'])->name('deleteTransaction');
        Route::get('/transaction/number', [TransactionController::class, 'getTransactionNumber'])->name('getTransactionNumber');
    });

    // Archive

    Route::group(['middleware' => 'can:archive', 'prefix' => '/archive'], function () {
        Route::get('/documents', [ArchiveController::class, 'getDocuments'])->name('getDocuments');
        Route::get('/documents/{id}', [ArchiveController::class, 'getDocument'])->name('getDocument');
        Route::post('/documents', [ArchiveController::class, 'createDocument'])->name('createDocument');
        Route::put('/documents/{id}', [ArchiveController::class, 'updateDocument'])->name('updateDocument');
        Route::delete('/documents/{id}', [ArchiveController::class, 'deleteDocument'])->name('deleteDocument');
        Route::put('/documents/{id}/restore', [ArchiveController::class, 'restoreDocument'])->name('restoreDocument');
        Route::put('/documents/{id}/force-delete', [ArchiveController::class, 'forceDeleteDocument'])->name('forceDeleteDocument');
        Route::put('/documents/{id}/move', [ArchiveController::class, 'moveDocument'])->name('moveDocument');
    });

    // Support Ticket
    Route::group(['middleware' => 'can:support'], function () {
        Route::get('/support-tickets', [SupportTicketController::class, 'getTickets'])->name('getTickets');
        Route::get('/support-tickets/{id}', [SupportTicketController::class, 'getTicket'])->name('getTicket');
        Route::post('/support-tickets', [SupportTicketController::class, 'createTicket'])->name('createSupportTicket');
        Route::put('/support-tickets/{id}', [SupportTicketController::class, 'updateTicket'])->name('updateTicket');
        Route::delete('/support-tickets/{id}', [SupportTicketController::class, 'deleteTicket'])->name('deleteTicket');
        Route::get('/support-tickets/{id}/messages', [SupportTicketController::class, 'getTicketMessages'])->name('getTicketMessages');
        Route::post('/support-tickets/{id}/messages', [SupportTicketController::class, 'createTicketMessage'])->name('createTicketMessage');
        Route::put('/support-tickets/messages/{id}', [SupportTicketController::class, 'updateTicketMessage'])->name('updateTicketMessage');
        Route::delete('/support-tickets/messages/{id}', [SupportTicketController::class, 'deleteTicketMessage'])->name(
            'deleteTicketMessage'
        );
        Route::get('/support-ticket/number', [SupportTicketController::class, 'getTicketNumber'])->name('getTicketNumber');
        Route::get('/support-ticket/share/{id}', [SupportTicketController::class, 'shareTicket'])->name('shareTicket');
    });

    // Contract
    Route::group(['middleware' => 'can:contracts'], function () {
        Route::get('/contracts', [ContractController::class, 'getContracts'])->name('getContracts');
        Route::get('/contracts/{id}', [ContractController::class, 'getContract'])->name('getContract');
        Route::post('/contracts', [ContractController::class, 'createContract'])->name('createContract');
        Route::put('/contracts/{id}', [ContractController::class, 'updateContract'])->name('updateContract');
        Route::delete('/contracts/{id}', [ContractController::class, 'deleteContract'])->name('deleteContract');
        Route::get('/contract/number', [ContractController::class, 'getContractNumber'])->name('getContractNumber');
        Route::post('/contract/{id}/share', [ContractController::class, 'shareContract'])->name('shareContract');
    });

    // Payments
    Route::group(['middleware' => 'can:payments'], function () {
        Route::get('/payments', [PaymentController::class, 'getPayments'])->name('getPayments');
        Route::get('/payments/{id}', [PaymentController::class, 'getPayment'])->name('getPayment');
    });

    Route::post('/create_webhook', [DataController::class, 'createWebhookSubscription'])
        ->name('createWebhookSubscription')
        ->middleware('can:webhooks');
    
    // Test this function on the Zapier app
    Route::delete('/delete_webhook', [DataController::class, 'deleteWebhookSubscription'])
        ->name('deleteWebhookSubscription')
        ->middleware('can:webhooks');

    Route::group(['prefix' => 'admin'], function () {
        // Dashboard Data
        Route::get('/dashboard', [AdminDashboardDataController::class, 'returnData'])->name('adminReturnDashboardData');
        // User
        Route::group(['middleware' => 'can:admin_users'], function () {
            Route::get('/users', [AdminUserController::class, 'getUsers'])->name('adminGetUsers');
            Route::get('/users/{id}', [AdminUserController::class, 'getUser'])->name('adminGetUser');
            Route::post('/users', [AdminUserController::class, 'createUser'])->name('adminCreateUser');
            Route::put('/users/{id}', [AdminUserController::class, 'updateUser'])->name('adminUpdateUser');
            Route::delete('/users/{id}', [AdminUserController::class, 'deleteUser'])->name('adminDeleteUser');
            Route::put('/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('adminResetPassword');
            Route::post('/users/{id}/disable-2fa', [AdminUserController::class, 'disable2fa'])->name('adminDisable2fa');
        });

        // Department
        Route::group(['middleware' => 'can:admin_departments', 'prefix' => 'departments'], function () {
            Route::get('/', [AdminDepartmentController::class, 'getDepartments'])->name('adminGetDepartments');
            Route::get('/{id}', [AdminDepartmentController::class, 'getDepartment'])->name('adminGetDepartment');
            Route::post('/', [AdminDepartmentController::class, 'createDepartment'])->name('adminCreateDepartment');
            Route::put('/{id}', [AdminDepartmentController::class, 'updateDepartment'])->name('adminUpdateDepartment');
            Route::delete('/{id}', [AdminDepartmentController::class, 'deleteDepartment'])->name('adminDeleteDepartment');
        });

        // Role
        Route::group(['middleware' => 'can:admin_roles'], function () {
            Route::get('/roles', [AdminPermissionRoleController::class, 'getRoles'])->name('adminGetRoles');
            Route::get('/roles/{id}', [AdminPermissionRoleController::class, 'getRole'])->name('adminGetRole');
            Route::post('/roles', [AdminPermissionRoleController::class, 'createRole'])->name('adminCreateRole');
            Route::put('/roles/{id}', [AdminPermissionRoleController::class, 'updateRole'])->name('adminUpdateRole');
            Route::delete('/roles/{id}', [AdminPermissionRoleController::class, 'deleteRole'])->name('adminDeleteRole');
            Route::get('/permissions', [AdminPermissionRoleController::class, 'getPermissions'])->name('getPermissions');
        });

        // Tax
        Route::group(['middleware' => 'can:admin_tax_rates'], function () {
            Route::get('/taxes', [AdminTaxController::class, 'getTaxes'])->name('adminGetTaxes');
            Route::get('/taxes/{id}', [AdminTaxController::class, 'getTax'])->name('adminGetTax');
            Route::post('/taxes', [AdminTaxController::class, 'createTax'])->name('adminCreateTax');
            Route::put('/taxes/{id}', [AdminTaxController::class, 'updateTax'])->name('adminUpdateTax');
            Route::delete('/taxes/{id}', [AdminTaxController::class, 'deleteTax'])->name('adminDeleteTax');
        });

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'getSettings'])->name('adminGetSettings');
        Route::put('/settings', [AdminSettingController::class, 'updateSettings'])->name('adminUpdateSettings');

        Route::get('/settings/company', [AdminSettingController::class, 'getCompanySettings'])->name('adminGetCompanySettings');
        Route::put('/settings/company', [AdminSettingController::class, 'updateCompanySettings'])->name('adminUpdateCompanySettings');

        // Numbering
        Route::group(['middleware' => 'can:admin_numbering'], function () {
            Route::get('/settings/numbering', [AdminSettingController::class, 'getNumberingSettings'])->name('adminGetNumberingSettings');
            Route::put('/settings/numbering', [AdminSettingController::class, 'updateNumberingSettings'])->name(
                'adminUpdateNumberingSettings'
            );
            Route::post('/settings/number/preview', [AdminSettingController::class, 'generatePreviewNumber'])->name(
                'adminGeneratePreviewNumber'
            );
        });
        Route::post('/settings/company/logo', [AdminSettingController::class, 'setCompanyLogo'])->name('adminSetCompanyLogo');
        Route::delete('/settings/company/logo', [AdminSettingController::class, 'removeCompanyLogo'])->name('adminRemoveCompanyLogo');

        // Email
        Route::group(['middleware' => 'can:admin_email_settings'], function () {
            Route::get('/settings/email', [AdminSettingController::class, 'getEmailSettings'])->name('adminGetEmailSettings');
            Route::put('/settings/email', [AdminSettingController::class, 'updateEmailSettings'])->name('adminUpdateEmailSettings');
            Route::post('/settings/email/test', [AdminSettingController::class, 'sentTestEmail'])->name('adminSentTestEmail');
        });

        // Unit
        Route::group(['middleware' => 'can:admin_units'], function () {
            Route::get('/units', [AdminUnitController::class, 'getUnits'])->name('adminGetUnits');
            Route::get('/units/{id}', [AdminUnitController::class, 'getUnit'])->name('adminGetUnit');
            Route::post('/units', [AdminUnitController::class, 'createUnit'])->name('adminCreateUnit');
            Route::put('/units/{id}', [AdminUnitController::class, 'updateUnit'])->name('adminUpdateUnit');
            Route::delete('/units/{id}', [AdminUnitController::class, 'deleteUnit'])->name('adminDeleteUnit');
        });

        // Currency
        Route::group(['middleware' => 'can:admin_currencies'], function () {
            Route::get('/currency/live-update', [AdminCurrencyController::class, 'liveUpdateCurrencyRate'])->name(
                'adminLiveUpdateCurrencyRate'
            );
            Route::get('/currencies', [AdminCurrencyController::class, 'getCurrencies'])->name('adminGetCurrencies');
            Route::get('/currencies/{id}', [AdminCurrencyController::class, 'getCurrency'])->name('adminGetCurrency');
            Route::post('/currencies', [AdminCurrencyController::class, 'createCurrency'])->name('adminCreateCurrency');
            Route::put('/currencies/{id}', [AdminCurrencyController::class, 'updateCurrency'])->name('adminUpdateCurrency');
            Route::delete('/currencies/{id}', [AdminCurrencyController::class, 'deleteCurrency'])->name('adminDeleteCurrency');
        });

        // Webhooks
        Route::group(['middleware' => 'can:admin_webhooks'], function () {
            Route::get('/webhook_subscriptions', [AdminWebhookSubscriptionController::class, 'getWebhookSubscriptions'])->name(
                'adminGetWebhookSubscriptions'
            );
            Route::get('/webhook_subscriptions/{id}', [AdminWebhookSubscriptionController::class, 'getWebhookSubscription'])->name(
                'adminGetWebhookSubscription'
            );
            Route::post('/webhook_subscriptions', [AdminWebhookSubscriptionController::class, 'createWebhookSubscription'])->name(
                'adminCreateWebhookSubscription'
            );
            Route::put('/webhook_subscriptions/{id}', [AdminWebhookSubscriptionController::class, 'updateWebhookSubscription'])->name(
                'adminUpdateWebhookSubscription'
            );
            Route::delete('/webhook_subscriptions/{id}', [AdminWebhookSubscriptionController::class, 'deleteWebhookSubscription'])->name(
                'adminDeleteWebhookSubscription'
            );
        });
    });
});

// Anonymous routes
Route::group(['prefix' => 'client'], function () {
    Route::get('/invoice', [ClientInvoiceController::class, 'getInvoice'])->name('clientGetInvoice');
    Route::get('/quote', [ClientQuoteController::class, 'getQuote'])->name('clientGetQuote');
    Route::post('/quote/accept-reject', [ClientQuoteController::class, 'acceptRejectQuote'])->name('clientAcceptRejectQuote');
    Route::get('/support-ticket', [ClientSupportTicketController::class, 'getTicket'])->name('clientGetTicket');
    Route::post('/support-ticket', [ClientSupportTicketController::class, 'replayOnTicket'])->name('clientReplayOnTicket');
    Route::get('/contract', [ClientContractController::class, 'getContract'])->name('clientGetContract');
    Route::post('/contract/sign', [ClientContractController::class, 'signContract'])->name('clientSignContract');
});

// Payment routes
Route::post('/online-payment/invoice/stripe', [ClientInvoiceController::class, 'payInvoiceStripe'])->name('clientPayInvoiceStripe');
Route::get('/online-payment/invoice/stripe', [ClientInvoiceController::class, 'validateInvoiceStripePayment'])->name(
    'validateStripePayment'
);
Route::post('/online-payment/invoice/paypal', [ClientInvoiceController::class, 'payInvoicePayPal'])->name('clientPayInvoicePayPal');
Route::get('/online-payment/invoice/paypal', [ClientInvoiceController::class, 'validateInvoicePayPalPayment'])->name(
    'validatePayPalPayment'
);

// Installation routes
Route::get('/install/check-app-installed', [InstallerController::class, 'checkAppInstalled'])->name('checkAppInstalled');
Route::group(['prefix' => 'install', 'middleware' => CheckIfInstalled::class], function () {
    Route::get('/check-requirements', [InstallerController::class, 'checkRequirements'])->name('checkRequirements');
    Route::post('/check-db-connection', [InstallerController::class, 'checkDbConnection'])->name('checkDbConnection');
    Route::post('/save-db-connection', [InstallerController::class, 'updateEnvFileWithDbInfo'])->name('updateEnvFileWithDbInfo');
    Route::post('/migrate-seed', [InstallerController::class, 'migrateAndSeed'])->name('migrateAndSeed');
    Route::post('/set-settings', [InstallerController::class, 'setSettingsInDb'])->name('setSettingsInDb');
    Route::post('/create-user', [InstallerController::class, 'createAdminUser'])->name('createAdminUser');
});

// Signed URLs
Route::get('/archive/documents/{id}/preview', [ArchiveController::class, 'previewDocument'])->name('previewDocument');
Route::get('/archive/documents/{id}/download', [ArchiveController::class, 'downloadDocument'])->name('downloadDocument');
Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'getInvoicePdf'])->name('getInvoicePdf');
Route::get('/quote/{id}/pdf', [QuoteController::class, 'getQuotePdf'])->name('getQuotePdf');
Route::get('/bill/{id}/pdf', [BillController::class, 'getBillPdf'])->name('getBillPdf');
Route::get('/contract/{id}/pdf', [ContractController::class, 'getContractPdf'])->name('getContractPdf');
