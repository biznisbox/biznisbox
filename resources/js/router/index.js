import { jwtDecode } from 'jwt-decode'
import { createRouter, createWebHistory } from 'vue-router'
import { useCookies } from 'vue3-cookies'
const { cookies } = useCookies()

const routes = [
    // Auth
    makeRoute('/auth/login', 'auth-login', () => import('../views/auth/Login.vue'), { auth: false }),
    makeRoute('/auth/logout', 'auth-logout', () => import('../views/auth/Logout.vue'), { auth: true }),
    // Dashboard
    makeRoute('/', 'dashboard', () => import('../views/Dashboard.vue'), { auth: true }),
    makeRoute('/profile', 'profile', () => import('../views/Profile.vue'), { auth: true }),

    // Products
    makeRoute('/products', 'products', () => import('../views/products/Products.vue'), { auth: true }),
    makeRoute('/products/create', 'product-create', () => import('../views/products/CreateProduct.vue'), { auth: true }),
    makeRoute('/products/:id', 'product-view', () => import('../views/products/ViewProduct.vue'), { auth: true }),
    makeRoute('/products/:id/edit', 'product-edit', () => import('../views/products/EditProduct.vue'), { auth: true }),

    // Partners
    makeRoute('/partners', 'partners', () => import('../views/partners/Partners.vue'), { auth: true }),
    makeRoute('/partners/create', 'partner-create', () => import('../views/partners/CreatePartner.vue'), { auth: true }),
    makeRoute('/partners/:id', 'partner-view', () => import('../views/partners/ViewPartner.vue'), { auth: true }),
    makeRoute('/partners/:id/edit', 'partner-edit', () => import('../views/partners/EditPartner.vue'), { auth: true }),

    // Invoices
    makeRoute('/invoices', 'invoices', () => import('../views/invoices/Invoices.vue'), { auth: true }),
    makeRoute('/invoices/create', 'invoice-create', () => import('../views/invoices/CreateInvoice.vue'), { auth: true }),
    makeRoute('/invoices/:id', 'invoice-view', () => import('../views/invoices/ViewInvoice.vue'), { auth: true }),
    makeRoute('/invoices/:id/edit', 'invoice-edit', () => import('../views/invoices/EditInvoice.vue'), { auth: true }),

    // Quotes
    makeRoute('/quotes', 'quotes', () => import('../views/quotes/Quotes.vue'), { auth: true }),
    makeRoute('/quotes/create', 'quote-create', () => import('../views/quotes/CreateQuote.vue'), { auth: true }),
    makeRoute('/quotes/:id', 'quote-view', () => import('../views/quotes/ViewQuote.vue'), { auth: true }),
    makeRoute('/quotes/:id/edit', 'quote-edit', () => import('../views/quotes/EditQuote.vue'), { auth: true }),

    // Bills
    makeRoute('/bills', 'bills', () => import('../views/bills/Bills.vue'), { auth: true }),
    makeRoute('/bills/create', 'bill-create', () => import('../views/bills/CreateBill.vue'), { auth: true }),
    makeRoute('/bills/:id', 'bill-view', () => import('../views/bills/ViewBill.vue'), { auth: true }),
    makeRoute('/bills/:id/edit', 'bill-edit', () => import('../views/bills/EditBill.vue'), { auth: true }),

    // Employees
    makeRoute('/employees', 'employees', () => import('../views/employees/Employees.vue'), { auth: true }),
    makeRoute('/employees/create', 'employee-create', () => import('../views/employees/CreateEmployee.vue'), { auth: true }),
    makeRoute('/employees/:id', 'employee-view', () => import('../views/employees/ViewEmployee.vue'), { auth: true }),
    makeRoute('/employees/:id/edit', 'employee-edit', () => import('../views/employees/EditEmployee.vue'), { auth: true }),

    // Account
    makeRoute('/accounts', 'accounts', () => import('../views/accounts/Accounts.vue'), { auth: true }),
    makeRoute('/accounts/create', 'account-create', () => import('../views/accounts/CreateAccount.vue'), { auth: true }),
    makeRoute('/accounts/:id', 'account-view', () => import('../views/accounts/ViewAccount.vue'), { auth: true }),
    makeRoute('/accounts/:id/edit', 'account-edit', () => import('../views/accounts/EditAccount.vue'), { auth: true }),

    // Transactions
    makeRoute('/transactions', 'transactions', () => import('../views/transactions/Transactions.vue'), { auth: true }),
    makeRoute('/transactions/create', 'transaction-create', () => import('../views/transactions/CreateTransaction.vue'), { auth: true }),
    makeRoute('/transactions/:id', 'transaction-view', () => import('../views/transactions/ViewTransaction.vue'), { auth: true }),
    makeRoute('/transactions/:id/edit', 'transaction-edit', () => import('../views/transactions/EditTransaction.vue'), { auth: true }),

    // Contracts
    makeRoute('/contracts', 'contracts', () => import('../views/contracts/Contracts.vue'), { auth: true }),
    makeRoute('/contracts/create', 'contract-create', () => import('../views/contracts/CreateContract.vue'), { auth: true }),
    makeRoute('/contracts/:id', 'contract-view', () => import('../views/contracts/ViewContract.vue'), { auth: true }),
    makeRoute('/contracts/:id/edit', 'contract-edit', () => import('../views/contracts/EditContract.vue'), { auth: true }),

    // Payments
    makeRoute('/payments', 'payments', () => import('../views/payments/Payments.vue'), { auth: true }),
    makeRoute('/payments/:id', 'payment-view', () => import('../views/payments/ViewPayment.vue'), { auth: true }),

    // Calendar
    makeRoute('/calendar', 'calendar', () => import('../views/Calendar.vue'), { auth: true }),

    // Archive
    makeRoute('/archive', 'archive', () => import('../views/archive/Archive.vue'), { auth: true }),

    // Support Tickets
    makeRoute('/support', 'support-tickets', () => import('../views/support/SupportTickets.vue'), { auth: true }),
    makeRoute('/support/create', 'support-ticket-create', () => import('../views/support/CreateSupportTicket.vue'), { auth: true }),
    makeRoute('/support/:id', 'support-ticket-view', () => import('../views/support/ViewSupportTicket.vue'), { auth: true }),

    // Admin
    makeRoute('/admin', 'admin', () => import('../views/admin/AdminDashboard.vue'), { auth: true, admin: true }),

    // Admin - Users
    makeRoute('/admin/users', 'admin-users', () => import('../views/admin/users/Users.vue'), { auth: true, admin: true }),
    makeRoute('/admin/users/create', 'admin-user-create', () => import('../views/admin/users/CreateUser.vue'), { auth: true, admin: true }),
    makeRoute('/admin/users/:id', 'admin-user-view', () => import('../views/admin/users/ViewUser.vue'), { auth: true, admin: true }),
    makeRoute('/admin/users/:id/edit', 'admin-user-edit', () => import('../views/admin/users/EditUser.vue'), { auth: true, admin: true }),

    // Admin - Departments
    makeRoute('/admin/departments', 'admin-departments', () => import('../views/admin/departments/Departments.vue'), {
        auth: true,
        admin: true,
    }),
    makeRoute('/admin/departments/create', 'admin-department-create', () => import('../views/admin/departments/CreateDepartment.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/departments/:id', 'admin-department-view', () => import('../views/admin/departments/ViewDepartment.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/departments/:id/edit', 'admin-department-edit', () => import('../views/admin/departments/EditDepartment.vue'), {
        auth: true,
        admin: true,
    }),

    // Admin - Roles
    makeRoute('/admin/roles', 'admin-roles', () => import('../views/admin/roles/Roles.vue'), { auth: true, admin: true }),
    makeRoute('/admin/roles/create', 'admin-role-create', () => import('../views/admin/roles/CreateRole.vue'), { auth: true, admin: true }),
    makeRoute('/admin/roles/:id', 'admin-role-view', () => import('../views/admin/roles/ViewRole.vue'), { auth: true, admin: true }),
    makeRoute('/admin/roles/:id/edit', 'admin-role-edit', () => import('../views/admin/roles/EditRole.vue'), { auth: true, admin: true }),

    // Admin - Settings
    makeRoute('/admin/settings/taxes', 'admin-settings-tax', () => import('../views/admin/settings/Taxes.vue'), {
        auth: true,
        admin: true,
    }),
    makeRoute('/admin/settings/numbering', 'admin-settings-numbering', () => import('../views/admin/settings/Numbering.vue'), {
        auth: true,
        admin: true,
    }),
    makeRoute('/admin/company', 'admin-settings-company', () => import('../views/admin/settings/Company.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/webhooks', 'admin-webhooks', () => import('../views/admin/settings/Webhooks.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/settings/general', 'admin-settings', () => import('../views/admin/settings/General.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/settings/data-collection', 'admin-data-collection', () => import('../views/admin/settings/DataCollection.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/integrations', 'admin-integrations', () => import('../views/admin/settings/Integrations.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/settings/currencies', 'admin-settings-currencies', () => import('../views/admin/settings/Currency.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/settings/units', 'admin-settings-units', () => import('../views/admin/settings/Units.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/settings/email', 'admin-settings-email', () => import('../views/admin/settings/Email.vue'), {
        auth: true,
        admin: true,
    }),

    makeRoute('/admin/status-page', 'admin-status-page', () => import('../views/admin/settings/StatusPage.vue'), {
        auth: true,
        admin: true,
    }),

    // Anonymous routes
    makeRoute('/client/invoice/:id', 'client-invoice-view', () => import('../views/client/Invoice.vue'), { auth: false }),
    makeRoute('/client/quote/:id', 'client-quote-view', () => import('../views/client/Quote.vue'), { auth: false }),
    makeRoute('/client/support/:id', 'client-support-ticket-view', () => import('../views/client/SupportTicket.vue'), { auth: false }),
    makeRoute('/client/contract/:id', 'client-contract-view', () => import('../views/client/Contract.vue'), { auth: false }),

    // Install
    makeRoute('/install', 'install', () => import('../views/install/Requirements.vue'), { auth: false }),
    makeRoute('/install/database', 'install-database', () => import('../views/install/Database.vue'), { auth: false }),
    makeRoute('/install/migrate', 'install-migrate', () => import('../views/install/MigrateSeed.vue'), { auth: false }),
    makeRoute('/install/user', 'install-user', () => import('../views/install/User.vue'), { auth: false }),
    makeRoute('/install/company', 'install-company', () => import('../views/install/Company.vue'), { auth: false }),
    makeRoute('/install/finish', 'install-finished', () => import('../views/install/Finish.vue'), { auth: false }),

    // 404 - Not Found (Always keep this as the last route)
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('../views/Error.vue'),
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const token = cookies.get('token')
    if (to.meta.auth && !to.meta.admin) {
        // Check if route requires auth
        if (token) {
            next()
        } else {
            next({ name: 'auth-login', query: { redirect: to.fullPath } })
        }
    } else if (to.meta.admin) {
        // Check if route requires admin permissions
        if (token && jwtDecode(token).data.permissions.includes('admin')) {
            next()
        } else {
            next({ name: 'auth-login', query: { redirect: to.fullPath } })
        }
    } else if (to.name === 'auth-login') {
        // If user is already logged in, redirect to dashboard (only for login page)
        if (token) {
            next({ name: 'dashboard' })
        } else {
            next()
        }
    } else {
        next()
    }
})

/**
 * Function for creating routes
 * @param {string} path
 * @param {string} name
 * @param {string} view
 * @param {object} meta
 * @param {array} children
 * @returns {object} route
 */
function makeRoute(path, name, view, meta = {}, children = []) {
    return {
        path,
        name,
        component: view,
        meta,
        children,
    }
}

export default router
