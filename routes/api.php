<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\QuotationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OpenBankingController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\BasicController as AdminBasicController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Client\InvoiceController as ClientInvoiceController;
use App\Http\Controllers\Client\QuotationsController as ClientQuotationsController;
use App\Http\Controllers\PartnerController;
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
    Route::get('/products', ProductController::class . '@getProducts');
    Route::middleware('can:products')->group(function () {
        Route::get('/products/{id}', ProductController::class . '@getProduct');
        Route::post('/products', ProductController::class . '@createProduct');
        Route::put('/products/{id}', ProductController::class . '@updateProduct');
        Route::delete('/products/{id}', ProductController::class . '@deleteProduct');
        Route::get('/product/product_number', ProductController::class . '@getProductNumber');
    });

    // Partners Routes
    Route::get('/partners_list', PartnerController::class . '@getPartnersLimitedData');
    Route::middleware(['can:partners'])->group(function () {
        Route::get('/partners', PartnerController::class . '@getPartners');
        Route::get('/partners/{id}', PartnerController::class . '@getPartner');
        Route::post('/partners', PartnerController::class . '@createPartner');
        Route::put('/partners/{id}', PartnerController::class . '@updatePartner');
        Route::delete('/partners/{id}', PartnerController::class . '@deletePartner');
        Route::get('/partner/partner_number', PartnerController::class . '@getPartnerNumber');
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
        Route::post('/invoice/transaction/{id}', InvoiceController::class . '@addTransaction');
    });

    // Quotes Routes
    Route::middleware('can:quotes')->group(function () {
        Route::get('/quotations', QuotationsController::class . '@getQuotes');
        Route::get('/quotations/{id}', QuotationsController::class . '@getQuote');
        Route::post('/quotations', QuotationsController::class . '@createQuote');
        Route::put('/quotations/{id}', QuotationsController::class . '@updateQuote');
        Route::delete('/quotations/{id}', QuotationsController::class . '@deleteQuote');
        Route::get('/quote/convert/{id}', QuotationsController::class . '@convertQuoteToInvoice');
        Route::get('/quote/quote_number', QuotationsController::class . '@getQuoteNumber');
        Route::get('/quote/share/{id}', QuotationsController::class . '@shareQuote');
    });

    // Categories Routes
    Route::get('/categories', BasicController::class . '@getCategories');
    Route::get('/categories/{id}', BasicController::class . '@getCategory');
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

    // Employees Routes
    Route::middleware('can:employees')->group(function () {
        Route::get('/employees', EmployeesController::class . '@getEmployees');
        Route::get('/employees/{id}', EmployeesController::class . '@getEmployee');
        Route::post('/employees', EmployeesController::class . '@createEmployee');
        Route::put('/employees/{id}', EmployeesController::class . '@updateEmployee');
        Route::delete('/employees/{id}', EmployeesController::class . '@deleteEmployee');
        Route::get('/employee/employee_number', EmployeesController::class . '@getEmployeeNumber');
    });

    // Accounts routes
    Route::get('/accounts', AccountController::class . '@getAccounts');
    Route::middleware('can:accounts')->group(function () {
        Route::get('/accounts/{id}', AccountController::class . '@getAccount');
        Route::post('/accounts', AccountController::class . '@createAccount');
        Route::put('/accounts/{id}', AccountController::class . '@updateAccount');
        Route::delete('/accounts/{id}', AccountController::class . '@deleteAccount');
        Route::get('/open_banking/banks', OpenBankingController::class . '@getBanks');
        Route::post('/open_banking/init_session', OpenBankingController::class . '@initSession');
        Route::post('/open_banking/get_requisition', OpenBankingController::class . '@getRequisition');
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

    // Archive routes
    Route::middleware('can:archive')
        ->prefix('/archive')
        ->group(function () {
            Route::get('/documents', ArchiveController::class . '@getDocuments');
            Route::get('/documents/file', ArchiveController::class . '@getDocument');
            Route::post('/documents', ArchiveController::class . '@createDocument');
            Route::put('/documents/file', ArchiveController::class . '@updateDocument');
            Route::delete('/documents/file', ArchiveController::class . '@deleteDocument');
            Route::get('/document/folders', ArchiveController::class . '@getFolders');
            Route::get('/document/folders/{id}', ArchiveController::class . '@getFolder');
            Route::post('/document/folders', ArchiveController::class . '@createFolder');
            Route::put('/document/folders', ArchiveController::class . '@updateFolder');
            Route::delete('/document/folders', ArchiveController::class . '@deleteFolder');
        });

    // Documents routes
    Route::middleware('can:documents')->group(function () {
        Route::get('/documents', DocumentController::class . '@getDocuments');
        Route::get('/documents/{id}', DocumentController::class . '@getDocument');
        Route::post('/documents', DocumentController::class . '@createDocument');
        Route::put('/documents/{id}', DocumentController::class . '@updateDocument');
        Route::delete('/documents/{id}', DocumentController::class . '@deleteDocument');
        Route::get('/document/number', DocumentController::class . '@getDocumentNumber');
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
            Route::get('/check_version', AdminSettingsController::class . '@checkVersion');
            Route::get('/check_server_status', AdminSettingsController::class . '@checkServerStatus');
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
                Route::post('/company_logo', AdminSettingsController::class . '@saveCompanyImage');
                Route::delete('/company_logo', AdminSettingsController::class . '@removeCompanyImage');
            });

            // Settings Routes
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

            // Departments Routes
            Route::middleware(['can:admin_departments'])->group(function () {
                Route::get('/departments', AdminDepartmentController::class . '@getDepartments');
                Route::get('/departments/{id}', AdminDepartmentController::class . '@getDepartment');
                Route::post('/departments', AdminDepartmentController::class . '@createDepartment');
                Route::put('/departments/{id}', AdminDepartmentController::class . '@updateDepartment');
                Route::delete('/departments/{id}', AdminDepartmentController::class . '@deleteDepartment');
                Route::get('/departments/employees', AdminDepartmentController::class . '@getDepartmentsWithEmployees');
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
    Route::get('/document/download', ArchiveController::class . '@downloadDocument')->name('documents.download');
    Route::get('/document/previews', ArchiveController::class . '@previewDocument')->name('documents.preview');
    Route::get('/invoice/pdf', InvoiceController::class . '@getInvoicePdf')->name('invoice.pdf');
    Route::get('/quote/pdf', QuotationsController::class . '@getQuotePdf')->name('quote.pdf');
    Route::get('/document-internal/pdf', DocumentController::class . '@getDocumentPdf')->name('document.pdf');
});

Route::prefix('/client')->group(function () {
    Route::get('/invoices', ClientInvoiceController::class . '@getInvoice');
    Route::get('/quote', ClientQuotationsController::class . '@getQuote');
    Route::post('/quote/accept-reject', ClientQuotationsController::class . '@acceptRejectQuote');
});

Route::get('{any}', function () {
    return response()->json(['message' => 'API route not available.'], 404);
})->where('any', '.*');

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working'], 200);
});
