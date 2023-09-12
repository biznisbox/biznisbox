import { createRouter, createWebHistory } from 'vue-router'
import { useCookies } from 'vue3-cookies'
const { cookies } = useCookies()
import jwtDecode from 'jwt-decode'
const routes = [
    // Dashboard
    makeRoute('/', 'Dashboard', () => import('../views/Dashboard.vue'), { auth: true }, []),
    makeRoute('/profile', 'Profile', () => import('../views/Profile.vue'), { auth: true }, []),

    // Auth
    makeRoute('/auth/login', 'AuthLogin', () => import('../views/auth/Login.vue')),
    makeRoute('/auth/logout', 'AuthLogout', () => import('../views/auth/Logout.vue')),
    makeRoute('/auth/reset-password', 'AuthResetPassword', () => import('../views/auth/ResetPassword.vue')),
    makeRoute('/auth/set-password/:email', 'AuthSetPassword', () => import('../views/auth/SetNewPassword.vue')),

    // Products Routes
    makeRoute('/products', 'products', () => import('../views/products/Products.vue'), { auth: true }, []),
    makeRoute('/products/new', 'new-product', () => import('../views/products/NewProduct.vue'), { auth: true }, []),
    makeRoute('/products/:id', 'view-product', () => import('../views/products/ViewProduct.vue'), { auth: true }, []),
    makeRoute('/products/:id/edit', 'edit-product', () => import('../views/products/EditProduct.vue'), { auth: true }, []),

    // Customers Routes
    makeRoute('/customers', 'customers', () => import('../views/customers/Customers.vue'), { auth: true }, []),
    makeRoute('/customers/new', 'new-customer', () => import('../views/customers/NewCustomer.vue'), { auth: true }, []),
    makeRoute('/customers/:id', 'view-customer', () => import('../views/customers/ViewCustomer.vue'), { auth: true }, []),
    makeRoute('/customers/:id/edit', 'edit-customer', () => import('../views/customers/EditCustomer.vue'), { auth: true }, []),

    // Partners Routes
    makeRoute('/partners', 'partners', () => import('../views/partners/Partners.vue'), { auth: true }, []),
    makeRoute('/partners/new', 'new-partner', () => import('../views/partners/NewPartner.vue'), { auth: true }, []),
    makeRoute('/partners/:id', 'view-partner', () => import('../views/partners/ViewPartner.vue'), { auth: true }, []),
    makeRoute('/partners/:id/edit', 'edit-partner', () => import('../views/partners/EditPartner.vue'), { auth: true }, []),

    // Calendar Routes
    makeRoute('/calendar', 'calendar', () => import('../views/calendar/Calendar.vue'), { auth: true }, []),

    // Invoice Routes
    makeRoute('/invoices', 'invoices', () => import('../views/invoices/Invoices.vue'), { auth: true }, []),
    makeRoute('/invoices/new', 'new-invoice', () => import('../views/invoices/NewInvoice.vue'), { auth: true }, []),
    makeRoute('/invoices/:id', 'view-invoice', () => import('../views/invoices/ViewInvoice.vue'), { auth: true }, []),
    makeRoute('/invoices/:id/edit', 'edit-invoice', () => import('../views/invoices/EditInvoice.vue'), { auth: true }, []),

    // Estimates Routes
    makeRoute('/estimates', 'estimates', () => import('../views/estimates/Estimates.vue'), { auth: true }, []),
    makeRoute('/estimates/new', 'new-estimate', () => import('../views/estimates/NewEstimate.vue'), { auth: true }, []),
    makeRoute('/estimates/:id', 'view-estimate', () => import('../views/estimates/ViewEstimate.vue'), { auth: true }, []),
    makeRoute('/estimates/:id/edit', 'edit-estimate', () => import('../views/estimates/EditEstimate.vue'), { auth: true }, []),

    // Account Routes
    makeRoute('/accounts', 'accounts', () => import('../views/accounts/Accounts.vue'), { auth: true }, []),
    makeRoute('/accounts/new', 'new-account', () => import('../views/accounts/NewAccount.vue'), { auth: true }, []),
    makeRoute('/accounts/:id', 'view-account', () => import('../views/accounts/ViewAccount.vue'), { auth: true }, []),
    makeRoute('/accounts/:id/edit', 'edit-account', () => import('../views/accounts/EditAccount.vue'), { auth: true }, []),

    // Transactions Routes
    makeRoute('/transactions', 'transactions', () => import('../views/transactions/Transactions.vue'), { auth: true }, []),
    makeRoute('/transactions/new', 'new-transaction', () => import('../views/transactions/NewTransaction.vue'), { auth: true }, []),
    makeRoute('/transactions/:id', 'view-transaction', () => import('../views/transactions/ViewTransaction.vue'), { auth: true }, []),
    makeRoute('/transactions/:id/edit', 'edit-transaction', () => import('../views/transactions/EditTransaction.vue'), { auth: true }, []),

    // Vendor Routes
    makeRoute('/vendors', 'vendors', () => import('../views/vendors/Vendors.vue'), { auth: true }, []),
    makeRoute('/vendors/new', 'new-vendor', () => import('../views/vendors/NewVendor.vue'), { auth: true }, []),
    makeRoute('/vendors/:id', 'view-vendor', () => import('../views/vendors/ViewVendor.vue'), { auth: true }, []),
    makeRoute('/vendors/:id/edit', 'edit-vendor', () => import('../views/vendors/EditVendor.vue'), { auth: true }, []),

    // Bills Routes
    makeRoute('/bills', 'bills', () => import('../views/bills/Bills.vue'), { auth: true }, []),
    makeRoute('/bills/new', 'new-bill', () => import('../views/bills/NewBill.vue'), { auth: true }, []),
    makeRoute('/bills/:id', 'view-bill', () => import('../views/bills/ViewBill.vue'), { auth: true }, []),
    makeRoute('/bills/:id/edit', 'edit-bill', () => import('../views/bills/EditBill.vue'), { auth: true }, []),

    // Archive Routes
    makeRoute('/archive', 'archive', () => import('../views/archive/Archive.vue'), { auth: true }, []),

    // Documents Routes
    makeRoute('/documents', 'documents', () => import('../views/documents/Documents.vue'), { auth: true }, []),
    makeRoute('/documents/new', 'new-document', () => import('../views/documents/NewDocument.vue'), { auth: true }, []),
    makeRoute('/documents/:id', 'view-document', () => import('../views/documents/ViewDocument.vue'), { auth: true }, []),
    makeRoute('/documents/:id/edit', 'edit-document', () => import('../views/documents/EditDocument.vue'), { auth: true }, []),

    // Admin Routes
    makeRoute('/admin', 'admin-dashboard', () => import('../views/admin/Dashboard.vue'), { auth: true, admin: true }, []),
    makeRoute('/admin/users', 'admin-users', () => import('../views/admin/users/Users.vue'), { auth: true, admin: true }, []),
    makeRoute('/admin/users/new', 'admin-new-user', () => import('../views/admin/users/NewUser.vue'), { auth: true, admin: true }, []),
    makeRoute('/admin/users/:id', 'admin-view-user', () => import('../views/admin/users/ViewUser.vue'), { auth: true, admin: true }, []),
    makeRoute(
        '/admin/users/:id/edit',
        'admin-edit-user',
        () => import('../views/admin/users/EditUser.vue'),
        { auth: true, admin: true },
        []
    ),
    makeRoute(
        '/admin/integrations',
        'admin-integrations',
        () => import('../views/admin/Integrations.vue'),
        { auth: true, admin: true },
        []
    ),
    makeRoute('/admin/company', 'admin-company', () => import('../views/admin/Company.vue'), { auth: true, admin: true }, []),
    makeRoute(
        '/admin/settings/general',
        'admin-settings-general',
        () => import('../views/admin/settings/General.vue'),
        { auth: true, admin: true },
        []
    ),
    makeRoute(
        '/admin/settings/currency',
        'admin-settings-currency',
        () => import('../views/admin/settings/Currency.vue'),
        {
            auth: true,
            admin: true,
        },
        []
    ),
    makeRoute(
        '/admin/settings/taxes',
        'admin-settings-taxes',
        () => import('../views/admin/settings/Taxes.vue'),
        { auth: true, admin: true },
        []
    ),
    makeRoute(
        '/admin/settings/numbering',
        'admin-settings-number',
        () => import('../views/admin/settings/Numbering.vue'),
        {
            auth: true,
            admin: true,
        },
        []
    ),
    makeRoute('/admin/roles', 'admin-roles', () => import('../views/admin/roles/Roles.vue'), { auth: true, admin: true }, []),
    makeRoute('/admin/roles/new', 'admin-new-role', () => import('../views/admin/roles/NewRole.vue'), { auth: true, admin: true }, []),
    makeRoute('/admin/roles/:id', 'admin-edit-role', () => import('../views/admin/roles/EditRole.vue'), { auth: true, admin: true }, []),
    // Client Routes
    makeRoute('/client/invoice/:id', 'client-invoice', () => import('../views/client/Invoice.vue'), { auth: false, client: true }, []),
    makeRoute('/client/estimate/:id', 'client-estimate', () => import('../views/client/Estimate.vue'), { auth: false, client: true }, []),

    // 404
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
            next({ name: 'AuthLogin' })
        }
    } else if (to.meta.admin) {
        // Check if route requires admin
        if (token && jwtDecode(token).data.permissions.includes('admin')) {
            next()
        } else {
            next({ name: 'AuthLogin' })
        }
    } else if (to.name === 'AuthLogin') {
        // If user is already logged in, redirect to dashboard (only for login page)
        if (token) {
            next({ name: 'Dashboard' })
        } else {
            next()
        }
    } else {
        next()
    }
})

/**
 * Function for creating routes
 *
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
