import { jwtDecode } from 'jwt-decode'
import dayjs from 'dayjs'
import CategoryMixin from '@/mixins/categories'
export default {
    name: 'IndexMixin',
    mixins: [CategoryMixin],
    data() {
        return {
            loadingData: false,
            token: this.$cookies.get('token') ? this.$cookies.get('token') : null,
            user: this.$cookies.get('token') ? jwtDecode(this.$cookies.get('token')) : null,
            validationErrors: {},
            lang: this.$i18n.locale,
            theme: this.$cookies.get('theme') ? this.$cookies.get('theme') : 'light',
            taxes: [],
            units: [],
            users: [],
            locales: [],
            currencies: [],
            departments: [],
            employees: [],
            notifications: [],
        }
    },

    methods: {
        /**
         * Function to make HTTP request
         * @param {string} method HTTP method (GET, POST, PUT, DELETE)
         * @param {string} url URL to make request
         * @param {array} data Data to send with request (optional)
         * @param {array} params Query parameters to send with request (optional)
         * @param {array} headers Headers to send with request (optional)
         * @param {boolean} showLoading Show loading indicator (optional) (default: true)
         * @returns {Promise}
         */
        makeHttpRequest(method = 'GET', url = '/', data = null, params = null, headers = null, showLoading = true) {
            this.loadingData = showLoading
            this.validationErrors = {}
            return new Promise((resolve, reject) => {
                this.$http
                    .request({
                        method: method,
                        url: url,
                        data: data,
                        params: params,
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                            'Accept-Language': this.$i18n.locale,
                            Language: this.$i18n.locale,
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: this.token ? 'Bearer ' + this.token : '',
                            ...headers,
                        },
                    })
                    .then((response) => {
                        resolve(response)
                    })
                    .catch((error) => {
                        // If error is 401 Unauthorized, redirect to login page
                        if (error.response.status === 401 && this.$route.name !== 'auth-login') {
                            this.showToast(this.$t('errors.session_timeout'), this.$t('basic.error'), 'error')
                            this.$cookies.remove('token')
                            this.$router.push({ name: 'auth-login', query: { redirect: this.$route.fullPath } })
                        }
                        // If error with 401 Unauthorized and user is on login page, show invalid credentials error
                        if (error.response.status === 401 && this.$route.name === 'auth-login') {
                            this.showToast(this.$t('errors.invalid_credentials'), this.$t('basic.error'), 'error')
                        }
                        // If error is 422 Unprocessable Entity, show validation errors
                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors
                            this.showToast(this.$t('errors.validation_error'), this.$t('basic.error'), 'error')
                        }
                        // If error is 500 Internal Server Error, show error message
                        if (error.response.status === 500) {
                            this.showToast(this.$t('errors.internal_server_error'), this.$t('basic.error'), 'error')
                        }
                        if (error.response.status === 403) {
                            this.showToast(this.$t('errors.forbidden'), this.$t('basic.error'), 'error')
                        }
                        if (error.response.status === 400) {
                            this.showToast(this.$t('errors.bad_request'), this.$t('basic.error'), 'error')
                        }
                        if (error.response.status === 405) {
                            this.showToast(this.$t('errors.method_not_allowed'), this.$t('basic.error'), 'error')
                        }
                        if (error.response.status === 404) {
                            this.showToast(this.$t('errors.not_found'), this.$t('basic.error'), 'error')
                        }
                        // Handle other errors
                        reject(error)
                    })
                    .finally(() => {
                        this.loadingData = false
                    })
            })
        },

        /**
         * Function for refresh token
         * @returns {void} Refresh token
         */
        refreshToken() {
            this.makeHttpRequest('POST', '/api/auth/refresh').then((response) => {
                this.$cookies.set('token', response.data.data.access_token, response.data.data.expires_in)
                this.user = jwtDecode(response.data.data.access_token)
            })
        },

        /**
         * Function for show toast message
         * @param {string} massage Detail of the message
         * @param {string} summary Summary of the message - title (Success, Info, Warning, Error) (default: Success)
         * @param {string} severity Severity of the message (success, info, warn, error) (default: success)
         * @param {number} life Life of the message in milliseconds (default: 3000)
         * @returns {void} Show toast message
         **/
        showToast(massage, summary = this.$t('basic.success'), severity = 'success', life = 3000) {
            this.$toast.add({ severity: severity, summary: summary, detail: massage, life: life })
        },

        /**
         * Function to change language
         * @param {string} lang Language to change
         * @returns {void} Change language
         **/
        changeLang(lang) {
            this.$i18n.locale = lang
            this.$cookies.set('lang', lang, '1Y')
        },

        /**
         * Function to change theme
         * @param {string} theme Theme to change
         * @returns {void} Change theme
         **/
        changeTheme() {
            // Change theme value
            this.theme = this.theme === 'light' ? 'dark' : 'light'
            this.changeThemeApi(this.theme)
            // Add class to body tag
            document.querySelector('body').classList.remove('light', 'dark')
            document.querySelector('body').classList.add(this.theme)
            // Save theme in cookie
            this.$cookies.set('theme', this.theme, '1Y')
        },

        /**
         * Function for check if user has permission
         * @param {string} permission Permission to check
         * @returns {boolean} True if user has permission, false otherwise
         **/
        hasPermission(permission) {
            if (this.user.data?.permissions.includes(permission) || permission == '') {
                return true
            }
            return false
        },

        /**
         * Function for check if user has any permission from given array
         * @param {array} permissions Permissions to check
         * @returns {boolean} True if user has any permission, false otherwise
         **/
        hasAnyPermission(permissions) {
            if (permissions.length == 0) {
                return false
            }
            for (let i = 0; i < permissions.length; i++) {
                if (this.user.data?.permissions.includes(permissions[i])) {
                    return true
                }
            }
            return false
        },

        /**
         * Function for redirect to other site
         * @param {string} url URL to redirect
         * @returns {void} Redirect to other site
         **/
        goTo(url) {
            this.$router.push(url)
        },

        /**
         * Function for copy text to clipboard
         * @param {string} text Text to copy
         * @returns {void} Show success toast
         */
        copyToClipboard(text) {
            navigator.clipboard.writeText(text)
            this.showToast(this.$t('basic.copied_to_clipboard'))
        },

        /****************************************
         * Navigation functions
         ****************************************/
        viewInvoiceNavigation(rowData) {
            this.$router.push({
                name: 'invoice-view',
                params: { id: rowData.data.id },
            })
        },

        viewQuoteNavigation(rowData) {
            this.$router.push({
                name: 'quote-view',
                params: { id: rowData.data.id },
            })
        },

        viewBillNavigation(rowData) {
            this.$router.push({
                name: 'bill-view',
                params: { id: rowData.data.id },
            })
        },

        viewTransactionNavigation(rowData) {
            this.$router.push({
                name: 'transaction-view',
                params: { id: rowData.data.id },
            })
        },

        viewSupportTicketNavigation(rowData) {
            this.$router.push({
                name: 'support-ticket-view',
                params: { id: rowData.data.id },
            })
        },

        viewProductNavigation(rowData) {
            this.$router.push({
                name: 'product-view',
                params: { id: rowData.data.id },
            })
        },

        viewEmployeeNavigation(rowData) {
            this.$router.push({
                name: 'employee-view',
                params: { id: rowData.data.id },
            })
        },

        viewAccountNavigation(rowData) {
            this.$router.push({
                name: 'account-view',
                params: { id: rowData.data.id },
            })
        },

        viewPaymentNavigation(rowData) {
            this.$router.push({
                name: 'payment-view',
                params: { id: rowData.data.id },
            })
        },

        /*******************************
         * Data receive functions
         *******************************/
        getUnits() {
            this.makeHttpRequest('GET', '/api/data?type=units').then((response) => {
                this.units = response.data.data
            })
        },

        getTaxes() {
            this.makeHttpRequest('GET', '/api/data?type=taxes').then((response) => {
                this.taxes = response.data.data
            })
        },

        getUsers() {
            this.makeHttpRequest('GET', '/api/data?type=users').then((response) => {
                this.users = response.data.data
            })
        },

        changeThemeApi(theme) {
            this.makeHttpRequest('POST', '/api/profile/theme', { theme: theme })
        },

        getLocales() {
            this.makeHttpRequest('GET', '/api/data?type=locales').then((response) => {
                this.locales = response.data.data
            })
        },

        getDepartments() {
            this.makeHttpRequest('GET', '/api/data?type=departments').then((response) => {
                this.departments = response.data.data
            })
        },

        getCurrencies() {
            this.makeHttpRequest('GET', '/api/data?type=currencies').then((response) => {
                this.currencies = response.data.data
            })
        },

        getEmployees() {
            this.makeHttpRequest('GET', '/api/data?type=employees').then((response) => {
                this.employees = response.data.data
            })
        },

        /*******************************
         * Notification
         *******************************/

        /**
         * Function to get notifications from API
         * @returns {void} Get notifications
         */
        getNotifications() {
            this.makeHttpRequest('GET', '/api/notifications').then((response) => {
                this.notifications = response.data.data
            })
        },

        /**
         * Function to mark notification as read
         * @param {uuid} notification_id ID of notification to mark as read
         * @returns {void} Mark notification as read
         */
        markNotificationAsRead(notification_id) {
            this.makeHttpRequest('POST', '/api/notifications/' + notification_id).then(() => {
                this.getNotifications()
            })
        },

        /*******************************
         * Data format functions
         *******************************/

        /**
         * Function for format addresses of partners
         * @param {object} partners Partners data (list of partners) from API
         * @param {number} partner_id ID of partner to format addresses
         * @return {object} Formatted addresses of partner
         */
        formatAddresses(partners, partner_id = null) {
            let addressesList = []
            let partnerData = partners.find((partner) => partner.id === partner_id).addresses

            partnerData.forEach((address) => {
                addressesList.push({
                    id: address.id,
                    address: address.address,
                    zip_code: address.zip_code,
                    city: address.city,
                    country: address.country,
                    addressText: `${address.address ?? ''} - ${address.zip_code ?? ''} - ${address.city ?? ''}  - ${address.country ?? ''}`,
                })
            })
            return addressesList
        },

        /**
         * Function to format date
         * @param {DateTime} value
         * @param {boolean} unix If true, value is in unix timestamp format
         * @returns {string} Formatted date
         */
        formatDate(value, unix = false) {
            if (unix) {
                return dayjs(value, 'X').format(this.$settings.date_format)
            }
            if (value === null) return null
            return dayjs(value).format(this.$settings.date_format)
        },

        /**
         * Function to format date and time
         * @param {string} value Date and time
         * @param {boolean} unix - If true, value is in unix timestamp format
         * @returns {string} Formatted date and time
         */
        formatDateTime(value, unix = false) {
            if (value === null) return null
            if (unix) {
                return dayjs(value, 'X').format(this.$settings.datetime_format)
            }

            return dayjs(value).format(this.$settings.datetime_format)
        },

        /**
         * Function to format time
         * @param {string} value
         * @param {boolean} unix If true, value is in unix timestamp format
         * @returns {string} Formatted time
         */
        formatTime(value, unix = false) {
            if (value === null) return null
            if (unix) {
                return dayjs(value, 'X').format(this.$settings.time_format)
            }
            return dayjs(value).format(this.$settings.time_format)
        },

        /**
         * Function to format text to be blank if it is null
         * @param {string} value
         * @returns {string} Formatted text
         * */
        formatText(value) {
            return value === null ? '' : value
        },

        /**
         * Function to format country
         * @param {string} value
         * @returns {string} Localized country name
         */
        formatCountry(value) {
            return value === null ? '' : this.$t('countries.' + value)
        },

        /**
         * Function to format money
         * @param {number} value
         * @returns {string} Formatted money
         */
        formatMoney(value, currency = null) {
            if (value === null || value === undefined) {
                return ''
            }
            if (currency === null || currency === undefined) {
                currency = this.$settings.default_currency
            }
            if (isNaN(value)) {
                // If value is not number, return value as it is (bug fix)
                return value + ' ' + currency
            }
            return value.toLocaleString(this.lang) + ' ' + currency
        },

        /**
         * Function for format file size
         * @param {number} bytes size in bytes
         * @param {number} decimals number of decimals
         * @returns {string} size
         **/
        formatFileSize(bytes, decimals = 2) {
            if (!+bytes) return '0 Bytes'

            const k = 1024
            const dm = decimals < 0 ? 0 : decimals
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

            const i = Math.floor(Math.log(bytes) / Math.log(k))

            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
        },

        /**
         * Function for check if application is installed
         * @returns {void} Redirect to login page if app is installed
         */
        checkIfInstalled() {
            this.makeHttpRequest('GET', '/api/install/check-app-installed', null, null, null, false).then((response) => {
                if (response.data.data.status == true) {
                    return this.$router.push({ name: 'auth-login' })
                }
            })
        },

        /**
         * Function for check if is mobile device
         * @returns {boolean} True if is mobile device, false otherwise
         */
        isMobile() {
            return window.innerWidth <= 768
        },
    },

    created() {
        // Add class to body tag for theme
        document.querySelector('body').classList.add(this.theme)

        // Set language
        if (this.$cookies.get('lang')) {
            this.$i18n.locale = this.$cookies.get('lang')
        }
        if (this.$route.query.lang) {
            this.$cookies.set('lang', this.$route.query.lang, '1Y')
            this.$i18n.locale = this.$route.query.lang
        }

        // Set title for page
        if (this.$settings?.company_name) {
            document.title = this.$settings.company_name
        }
    },

    computed: {
        /**
         * Get application settings
         * @returns {object} app settings
         **/
        $settings() {
            if (window.App?.settings) {
                return window.App?.settings
            }
        },
    },
}
