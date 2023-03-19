<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OpenBankingController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\BasicController as AdminBasicController;
use App\Http\Controllers\Client\InvoiceController as ClientInvoiceController;
use App\Http\Controllers\Client\EstimateController as ClientEstimateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/auth/login', AuthController::class . '@Login');
Route::post('/auth/reset_password', AuthController::class . '@SelfResetPassword');
Route::post('/auth/set_new_password', AuthController::class . '@setNewPassword');

Route::middleware('auth')->group(function () {
    Route::get('/auth/logout', AuthController::class . '@Logout')->middleware('auth');

    // Products Routes

    Route::middleware('can:products')->group(function () {
        Route::get('/products', ProductController::class . '@getProducts');
        Route::get('/products/{id}', ProductController::class . '@getProduct');
        Route::post('/products', ProductController::class . '@createProduct');
        Route::put('/products/{id}', ProductController::class . '@updateProduct');
        Route::delete('/products/{id}', ProductController::class . '@deleteProduct');
    });

    // Customers Routes
    Route::middleware('can:customers')->group(function () {
        Route::get('/customers', CustomersController::class . '@getCustomers');
        Route::get('/customers/{id}', CustomersController::class . '@getCustomer');
        Route::post('/customers', CustomersController::class . '@createCustomer');
        Route::put('/customers/{id}', CustomersController::class . '@updateCustomer');
        Route::delete('/customers/{id}', CustomersController::class . '@deleteCustomer');
    });

    // Invoice Routes
    Route::middleware('can:invoices')->group(function () {
        Route::get('/invoices', InvoiceController::class . '@getInvoices');
        Route::get('/invoices/{id}', InvoiceController::class . '@getInvoice');
        Route::post('/invoices', InvoiceController::class . '@createInvoice');
        Route::put('/invoices/{id}', InvoiceController::class . '@updateInvoice');
        Route::delete('/invoices/{id}', InvoiceController::class . '@deleteInvoice');
        Route::get('/invoice/invoice_number', InvoiceController::class . '@getInvoiceNumber');
        Route::get('/invoice/share/{id}', InvoiceController::class . '@shareInvoice');
        Route::post('/invoice/send/{id}', InvoiceController::class . '@sendInvoice');
    });

    // Estimate Routes
    Route::middleware('can:estimates')->group(function () {
        Route::get('/estimates', EstimateController::class . '@getEstimates');
        Route::get('/estimates/{id}', EstimateController::class . '@getEstimate');
        Route::post('/estimates', EstimateController::class . '@createEstimate');
        Route::put('/estimates/{id}', EstimateController::class . '@updateEstimate');
        Route::delete('/estimates/{id}', EstimateController::class . '@deleteEstimate');
        Route::get('/estimate/convert/{id}', EstimateController::class . '@convertEstimateToInvoice');
        Route::get('/estimate/estimate_number', EstimateController::class . '@getEstimateNumber');
        Route::get('/estimate/share/{id}', EstimateController::class . '@shareEstimate');
        Route::post('/estimate/send/{id}', EstimateController::class . '@sendEstimate');
    });

    // Categories Routes
    Route::get('/categories', BasicController::class . '@getCategories');
    Route::post('/categories', BasicController::class . '@createCategory');
    Route::put('/categories/{id}', BasicController::class . '@updateCategory');
    Route::delete('/categories/{id}', BasicController::class . '@deleteCategory');

    // Calendar Routes
    Route::middleware('can:calendar')->group(function () {
        Route::get('/calendars/events/{event_id}', CalendarController::class . '@getEvent');
        Route::post('/calendars/events', CalendarController::class . '@createEvent');
        Route::put('/calendars/events/{event_id}', CalendarController::class . '@updateEvent');
        Route::delete('/calendars/events/{event_id}', CalendarController::class . '@deleteEvent');
        Route::get('/calendar/events', CalendarController::class . '@getUserEvents');
    });

    // Accounts routes
    Route::middleware('can:accounts')->group(function () {
        Route::get('/accounts', AccountController::class . '@getAccounts');
        Route::get('/accounts/{id}', AccountController::class . '@getAccount');
        Route::post('/accounts', AccountController::class . '@createAccount');
        Route::put('/accounts/{id}', AccountController::class . '@updateAccount');
        Route::delete('/accounts/{id}', AccountController::class . '@deleteAccount');
    });

    // Transactions routes
    Route::middleware('can:transactions')->group(function () {
        Route::get('/transactions', TransactionController::class . '@getTransactions');
        Route::get('/transactions/{id}', TransactionController::class . '@getTransaction');
        Route::post('/transactions', TransactionController::class . '@createTransaction');
        Route::put('/transactions/{id}', TransactionController::class . '@updateTransaction');
        Route::delete('/transactions/{id}', TransactionController::class . '@deleteTransaction');
        Route::get('/transaction/transaction_number', TransactionController::class . '@getTransactionNumber');
    });

    // Open Banking routes
    Route::middleware('can:open_banking')->group(function () {
        Route::get('/open_banking/banks', OpenBankingController::class . '@getBanks');
        Route::post('/open_banking/init_session', OpenBankingController::class . '@initSession');
        Route::post('/open_banking/get_requisition', OpenBankingController::class . '@getRequisition');
        Route::get('/open_banking/accounts', OpenBankingController::class . '@getAccounts');
        Route::get('/open_banking/accounts/{id}', OpenBankingController::class . '@getAccountData');
        Route::put('/open_banking/accounts/{id}', OpenBankingController::class . '@updateAccountData');
    });

    // Documents routes
    Route::middleware('can:documents')->group(function () {
        Route::get('/documents', DocumentsController::class . '@getDocuments');
        Route::get('/documents/file', DocumentsController::class . '@getDocument');
        Route::post('/documents', DocumentsController::class . '@createDocument');
        Route::put('/documents/file', DocumentsController::class . '@updateDocument');
        Route::delete('/documents/file', DocumentsController::class . '@deleteDocument');
        Route::get('/document/folders', DocumentsController::class . '@getFolders');
        Route::post('/document/folders', DocumentsController::class . '@createFolder');
        Route::delete('/document/folders', DocumentsController::class . '@deleteFolder');
    });

    // Vendor Routes
    Route::middleware('can:vendors')->group(function () {
        Route::get('/vendors', VendorsController::class . '@getVendors');
        Route::get('/vendors/{id}', VendorsController::class . '@getVendor');
        Route::post('/vendors', VendorsController::class . '@createVendor');
        Route::put('/vendors/{id}', VendorsController::class . '@updateVendor');
        Route::delete('/vendors/{id}', VendorsController::class . '@deleteVendor');
    });

    // Bills Routes
    Route::middleware(['can:bills'])->group(function () {
        Route::get('/bills', BillController::class . '@getBills');
        Route::get('/bills/{id}', BillController::class . '@getBill');
        Route::post('/bills', BillController::class . '@createBill');
        Route::put('/bills/{id}', BillController::class . '@updateBill');
        Route::delete('/bills/{id}', BillController::class . '@deleteBill');
        Route::get('/bill/bill_number', BillController::class . '@getBillNumber');
    });

    // Basic Routes
    Route::get('/data', BasicController::class . '@getData');
    Route::get('/dashboard', BasicController::class . '@getDashboardData');

    Route::get('/my_profile', ProfileController::class . '@getUserProfile')->middleware('can:edit_own_profile');
    Route::put('/my_profile', ProfileController::class . '@updateUserProfile')->middleware('can:edit_own_profile');
    Route::put('/my_profile/password', ProfileController::class . '@updateUserPassword')->middleware('can:change_own_password');
    Route::post('/my_profile/avatar', ProfileController::class . '@changeAvatar')->middleware('can:edit_own_profile');
    Route::delete('/my_profile/avatar', ProfileController::class . '@removeAvatar')->middleware('can:edit_own_profile');

    // Admin Routes (Only for Admins)
    Route::middleware(['admin.auth', 'can:admin'])
        ->prefix('/admin')
        ->group(function () {
            // Dashboard Routes
            Route::get('/dashboard', AdminBasicController::class . '@getDashboardData');

            // User Routes
            Route::middleware(['can:admin_users'])->group(function () {
                Route::get('/users', AdminUsersController::class . '@getUsers');
                Route::get('/users/{id}', AdminUsersController::class . '@getUser');
                Route::post('/users', AdminUsersController::class . '@createUser');
                Route::put('/users/{id}', AdminUsersController::class . '@updateUser');
                Route::delete('/users/{id}', AdminUsersController::class . '@deleteUser');
                Route::post('/user/{id}/reset-password', AdminUsersController::class . '@resetUserPassword');
            });

            // Company Routes
            Route::middleware(['can:admin_company_settings'])->group(function () {
                Route::get('/company', AdminSettingsController::class . '@getCompanySettings');
                Route::put('/company', AdminSettingsController::class . '@updateCompanySettings');
            });
            Route::middleware(['can:admin_general_settings'])->group(function () {
                Route::get('/settings', AdminSettingsController::class . '@getSettings');
                Route::put('/settings', AdminSettingsController::class . '@updateSettings');
            });

            // Currency Routes
            Route::middleware(['can:admin_currencies'])->group(function () {
                Route::get('/currencies', AdminSettingsController::class . '@getCurrencies');
                Route::get('/currencies/{id}', AdminSettingsController::class . '@getCurrency');
                Route::post('/currencies', AdminSettingsController::class . '@createCurrency');
                Route::put('/currencies/{id}', AdminSettingsController::class . '@updateCurrency');
                Route::delete('/currencies/{id}', AdminSettingsController::class . '@deleteCurrency');
                Route::get('/currency/rates', AdminSettingsController::class . '@liveUpdateCurrencyRate');
            });

            // Tax Routes
            Route::middleware(['can:admin_tax_rates'])->group(function () {
                Route::get('/taxes', AdminSettingsController::class . '@getTaxes');
                Route::get('/taxes/{id}', AdminSettingsController::class . '@getTax');
                Route::post('/taxes', AdminSettingsController::class . '@createTax');
                Route::put('/taxes/{id}', AdminSettingsController::class . '@updateTax');
                Route::delete('/taxes/{id}', AdminSettingsController::class . '@deleteTax');
            });

            // Roles Routes
            Route::middleware(['can:admin_general_settings'])->group(function () {
                Route::get('/roles', AdminPermissionController::class . '@getRoles');
                Route::get('/roles/{id}', AdminPermissionController::class . '@getRoleById');
                Route::post('/roles', AdminPermissionController::class . '@createRole');
                Route::put('/roles/{id}', AdminPermissionController::class . '@updateRole');
                Route::delete('/roles/{id}', AdminPermissionController::class . '@deleteRole');
                Route::get('/permissions', AdminPermissionController::class . '@getPermissions');
            });
        });
});

Route::prefix('/online_payment')->group(function () {
    Route::post('/stripe', OnlinePaymentController::class . '@makeStripePayment');
    Route::get('/stripe/{status}', OnlinePaymentController::class . '@validateStripePayment');
    Route::post('/paypal', OnlinePaymentController::class . '@makePaypalPayment');
    Route::get('/paypal/{status}', OnlinePaymentController::class . '@validatePaypalPayment');
});

// Signed Routes
Route::middleware(['signed'])->group(function () {
    Route::get('/document/download', DocumentsController::class . '@downloadDocument')->name('documents.download');
    Route::get('/document/previews', DocumentsController::class . '@previewDocument')->name('documents.preview');
    Route::get('/invoice/pdf', InvoiceController::class . '@getInvoicePdf')->name('invoice.pdf');
    Route::get('/estimate/pdf', EstimateController::class . '@getEstimatePdf')->name('estimate.pdf');
});

Route::prefix('/client')->group(function () {
    Route::get('/invoices', ClientInvoiceController::class . '@getInvoice');
    Route::get('/estimates', ClientEstimateController::class . '@getEstimate');
    Route::post('/estimates/accept-reject', ClientEstimateController::class . '@acceptRejectEstimate');
});

Route::get('{any}', function () {
    return response()->json(['message' => 'API route not available.'], 404);
})->where('any', '.*');

Route::get('/', function () {
    return response()->json(['message' => 'API is working'], 200);
});
