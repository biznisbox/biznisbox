import GlobalMixin from '@/mixins/global'
import i18n from '@/plugins/i18n'
import jwtDecode from 'jwt-decode'
import moment from 'moment/moment'
export default {
    mixins: [GlobalMixin],
    data() {
        return {
            token: sessionStorage.getItem('token') ? sessionStorage.getItem('token') : null,
            user: sessionStorage.getItem('token') ? jwtDecode(sessionStorage.getItem('token')) : null,
            validationErrors: [],
            loadingData: false,
            lang: localStorage.getItem('lang') || window.App.settings.default_lang,
            theme: localStorage.getItem('theme') ? localStorage.getItem('theme') : 'light',
        }
    },

    created() {
        if (this.$route.query.lang) {
            this.lang = this.$route.query.lang
        }
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'light')
        }
        i18n.global.locale.value = this.lang
        moment.locale(this.lang)
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
                            Language: this.$i18n.locale,
                            Authorization: this.token ? 'Bearer ' + this.token : '',
                            ...headers,
                        },
                    })
                    .then((response) => {
                        resolve(response)
                    })
                    .catch((error) => {
                        // If error is 401 Unauthorized, redirect to login page
                        if (error.response.status === 401 && this.$route.name !== 'AuthLogin') {
                            this.showToast(this.$t('errors.session_timeout'), '', 'error')
                            sessionStorage.removeItem('token')
                            this.$router.push('/auth/login')
                        }
                        // If error with 401 Unauthorized and user is on login page, show invalid credentials error
                        if (error.response.status === 401 && this.$route.name === 'AuthLogin') {
                            this.showToast(this.$t('errors.invalid_credentials'), '', 'error')
                        }
                        // If error is 422 Unprocessable Entity, show validation errors
                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors
                            this.showToast(this.$t('errors.validation_errors'), '', 'error')
                        }
                        // If error is 500 Internal Server Error, show error message
                        if (error.response.status === 500) {
                            this.showToast(this.$t('errors.internal_server_error'), '', 'error')
                        }
                        if (error.response.status === 403) {
                            this.showToast(this.$t('errors.forbidden'), '', 'error')
                        }
                        if (error.response.status === 400) {
                            this.showToast(this.$t('errors.bad_request'), '', 'error')
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
         * Function for redirects user to the given path
         * @param {string object} path
         * @returns {void} Redirect to the given path
         **/
        cancel(path = '/') {
            this.$router.push(path)
        },

        /**
         * Function for redirect user to the given path
         * @param {string object} path
         * @returns {void} Redirect to the given path
         **/
        goTo(path = '/') {
            this.$router.push(path)
        },

        /**
         * Function to format date
         * @param {DateTime} value
         * @param {boolean} unix If true, value is in unix timestamp format
         * @returns {string} Formatted date
         */
        formatDate(value, unix = false) {
            if (unix) {
                return moment(value, 'X').format(this.$settings.date_format)
            }
            return moment(value).format(this.$settings.date_format)
        },

        /**
         * Function to format date and time
         * @param {string} value Date and time
         * @param {boolean} unix - If true, value is in unix timestamp format
         * @returns {string} Formatted date and time
         */
        formatDateTime(value, unix = false) {
            if (unix) {
                return moment(value, 'X').format(this.$settings.datetime_format)
            }
            return moment(value).format(this.$settings.datetime_format)
        },

        /**
         * Function to format time
         * @param {string} value
         * @param {boolean} unix If true, value is in unix timestamp format
         * @returns {string} Formatted time
         */
        formatTime(value, unix = false) {
            if (unix) {
                return moment(value, 'X').format(this.$settings.time_format)
            }
            return moment(value).format(this.$settings.time_format)
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
            if (currency === null || currency === undefined) {
                currency = this.$settings.default_currency
            }
            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' + currency
        },

        /**
         * Function for show toast message
         * @param {string} severity Severity of the message (success, info, warn, error)
         * @param {string} massage Summary of the message
         * @param {string} detail Detail of the message
         * @param {number} life Life of the message
         * @returns {void} Show toast message
         **/
        showToast(summary, massage, severity = 'success', life = 3000) {
            this.$toast.add({ severity: severity, summary: summary, detail: massage, life: life })
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
         * Function for copy text to clipboard
         * @param {string} text Text to copy
         * @returns {void} Show success toast
         */
        copyToClipboard(text) {
            navigator.clipboard.writeText(text)
            this.showToast(this.$t('basic.copied_to_clipboard'))
        },

        /**
         * Function for change theme
         * @param {string} theme Theme to change
         */
        changeTheme() {
            let theme = localStorage.getItem('theme')
            if (theme === 'light') {
                this.$primevue.changeTheme('lara-dark-blue', 'lara-light-blue', 'theme-link', () => {
                    localStorage.setItem('theme', 'dark')
                    this.theme = 'dark'
                })
            }
            if (theme === 'dark') {
                this.$primevue.changeTheme('lara-light-blue', 'lara-dark-blue', 'theme-link', () => {
                    localStorage.setItem('theme', 'light')
                    this.theme = 'light'
                })
            }
        },
    },

    computed: {
        /**
         * Get application settings
         * @returns {object} app settings
         **/
        $settings() {
            return window.App.settings
        },
    },
}
